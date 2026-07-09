<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Bill;
use App\Models\Transaction;
use App\Services\StudentService;
use App\Services\TransactionService;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingService
{
    protected $studentService;
    protected $transactionService;
    protected $whatsappService;

    public function __construct(
        StudentService $studentService,
        TransactionService $transactionService,
        WhatsAppServiceInterface $whatsappService
    ) {
        $this->studentService = $studentService;
        $this->transactionService = $transactionService;
        $this->whatsappService = $whatsappService;
    }

    /**
     * Create the next bill for a student and generate a Xendit Invoice.
     * Corresponds to StudentController::storeBill
     */
    public function createNextBill(Student $student, string $senderName = 'Admin Pusat'): array
    {
        // 1. Validation Checks
        if (!$student->package) {
            return ['success' => false, 'message' => 'Siswa tidak memiliki paket aktif.'];
        }

        if ($student->status === 'pending') {
            return ['success' => false, 'message' => 'Siswa masih status PENDING (Baru Daftar). Mohon lunasi tagihan pendaftaran pertama dulu.'];
        }

        if ($student->status === 'inactive') {
            return ['success' => false, 'message' => 'Siswa sudah tidak aktif. Tidak bisa membuat tagihan baru.'];
        }

        $package = $student->package;
        $dueDate = $student->next_billing_date ?? now();

        // 2. Max Bills Check
        $maxBills = 999;
        if ($student->billing_cycle === 'monthly') {
            $maxBills = round($package->duration / 30);
        } elseif ($student->billing_cycle === 'weekly') {
            $maxBills = round($package->duration / 7);
        } elseif ($student->billing_cycle === 'daily') {
            $maxBills = round($package->duration);
        }

        if ($maxBills > 0 && $student->billing_cycle !== 'full') {
            $billCount = $student->bills()->count();
            if ($billCount >= $maxBills) {
                return ['success' => false, 'message' => "Batas max tagihan ({$maxBills}x) untuk paket ini sudah tercapai."];
            }
        }

        // 3. End Date Check
        if ($student->join_date) {
            $endDate = $student->join_date->copy()->addDays($package->duration);
            if ($dueDate->greaterThanOrEqualTo($endDate)) {
                return ['success' => false, 'message' => 'Paket siswa ini SUDAH SELESAI (' . $endDate->format('d M Y') . '). Tidak bisa menagih lagi.'];
            }
        }

        $result = DB::transaction(function() use ($student, $package, $dueDate, $senderName) {
            $student = Student::where('id', $student->id)->lockForUpdate()->first();
            if (!$student || !$student->package) {
                return ['success' => false, 'message' => 'Siswa tidak memiliki paket aktif.'];
            }

            $package = $student->package;
            $dueDate = $student->next_billing_date ?? $dueDate;

            // 4. Duplicate Check (safe inside transaction with lock)
            $existingBill = \App\Models\Bill::where('student_id', $student->id)
                                            ->whereDate('due_date', $dueDate)
                                            ->lockForUpdate()
                                            ->first();
            if ($existingBill) {
                $this->advanceNextBillingDate($student, $package, $dueDate);
                return ['success' => false, 'message' => "Tagihan untuk periode " . $dueDate->format('d M Y') . " SUDAH ADA. Sistem telah memperbarui tanggal tagihan berikutnya. Silakan coba buat lagi."];
            }

            // 5. Calculate Amount
            $amount = $this->calculateAmount($student, $package);
            $title = "Tagihan " . $package->name . " - Periode " . $dueDate->format('d M Y');

            // 6. Create Bill and Transaction
            $bill = $student->bills()->create([
                'branch_id' => $student->branch_id,
                'title'    => $title,
                'amount'   => $amount,
                'due_date' => $dueDate,
                'status'   => 'UNPAID',
            ]);

            $invoiceCode = 'INV-' . time() . '-' . $student->id . '-B' . $bill->id;

            $transaction = $student->transactions()->create([
                'branch_id'    => $student->branch_id,
                'invoice_code' => $invoiceCode,
                'total_amount' => $amount,
                'status'       => 'PENDING',
                'payment_url'  => '#',
                'transaction_date' => now(),
            ]);

            return [
                'bill' => $bill,
                'transaction' => $transaction,
                'title' => $title,
                'amount' => $amount,
            ];
        });

        if (isset($result['success']) && !$result['success']) {
            return $result;
        }

        // 7. Call Xendit Service (outside transaction — HTTP call)
        $bill = $result['bill'];
        $transaction = $result['transaction'];
        $title = $result['title'];
        $amount = $result['amount'];

        $successUrl = route('landing.payment.show', ['invoice_code' => $transaction->invoice_code, 'status' => 'success']);
        $failureUrl = route('student.portal.index', ['token' => $student->access_token]);
        $description = "Pembayaran " . $title;

        $xenditResult = $this->transactionService->createInvoice($transaction, $student, $description, $successUrl, $failureUrl);

        if ($xenditResult['success']) {
            $bill->update([
                'transaction_id' => $transaction->id,
                'status' => 'PENDING'
            ]);

            $this->advanceNextBillingDate($student, $package, $dueDate);

            $this->sendBillNotification($student, $title, $amount, $senderName);

            return ['success' => true, 'message' => 'Tagihan berhasil dibuat! Invoice Xendit aktif.'];
        } else {
            return ['success' => false, 'message' => 'Tagihan dibuat tapi GAGAL generate Xendit Invoice: ' . $xenditResult['message']];
        }
    }

    /**
     * Process a manual cash payment for the NEXT period.
     * Corresponds to StudentController::storeManualPayment
     */
    public function processManualPayment(Student $student, string $senderName = 'Admin Pusat'): array
    {
        if (!$student->package) {
            return ['success' => false, 'message' => 'Siswa tidak memiliki paket aktif.'];
        }

        if ($student->status === 'inactive') {
            return ['success' => false, 'message' => 'Siswa sudah tidak aktif. Tidak bisa mencatat pembayaran.'];
        }

        $dueDate = $student->next_billing_date ?? now();

        return DB::transaction(function() use ($student, $dueDate, $senderName) {
            $student = Student::where('id', $student->id)->lockForUpdate()->first();
            if (!$student || !$student->package) {
                return ['success' => false, 'message' => 'Siswa tidak memiliki paket aktif.'];
            }

            $package = $student->package;
            $amount = $this->calculateAmount($student, $package);
            $dueDate = $student->next_billing_date ?? $dueDate;
            $title = "Pembayaran Tunai " . $package->name . " - Periode " . $dueDate->format('d M Y');

            $existingBill = Bill::where('student_id', $student->id)
                ->whereDate('due_date', $dueDate)
                ->lockForUpdate()
                ->first();
            if ($existingBill && $existingBill->status === 'PAID') {
                return ['success' => false, 'message' => "Tagihan untuk periode " . $dueDate->format('d M Y') . " sudah LUNAS sebelumnya."];
            }
            if ($existingBill && $existingBill->status === 'UNPAID') {
                return ['success' => false, 'message' => "Masih ada tagihan UNPAID untuk periode " . $dueDate->format('d M Y') . ". Silakan lunasi tagihan yang ada terlebih dahulu."];
            }

            $invoiceCode = 'INV-CASH-' . time() . '-' . $student->id;

            $transaction = $student->transactions()->create([
                'branch_id'    => $student->branch_id,
                'invoice_code' => $invoiceCode,
                'total_amount' => $amount,
                'status'       => 'PAID',
                'payment_url'  => '#',
                'transaction_date' => now(),
                'paid_at'      => now(),
                'payment_method' => 'CASH',
                'payment_channel' => 'ADMIN_MANUAL'
            ]);

            $student->bills()->create([
                'branch_id' => $student->branch_id,
                'title'    => $title,
                'amount'   => $amount,
                'due_date' => $dueDate,
                'status'   => 'PAID',
                'transaction_id' => $transaction->id
            ]);

            $this->studentService->processPaymentSuccess($student, $transaction, false);

            $this->sendManualPaymentNotification($student, $title, $amount, $senderName);

            return ['success' => true, 'message' => 'Pembayaran Tunai berhasil dicatat! Transaksi LUNAS.'];
        });
    }

    /**
     * Pay an existing bill manually (e.g. cash payment for a generated bill).
     * Corresponds to StudentController::payBillManually
     */
    public function payExistingBillManually(Student $student, Bill $bill, string $senderName = 'Admin Pusat'): array
    {
        if ($bill->student_id !== $student->id) {
             return ['success' => false, 'message' => 'Tagihan tidak valid untuk siswa ini.'];
        }

        if ($bill->status === 'PAID') {
            return ['success' => false, 'message' => 'Tagihan ini sudah lunas.'];
        }

        return DB::transaction(function() use ($student, $bill, $senderName) {
            $invoiceCode = 'INV-MANUAL-' . time() . '-' . $student->id . '-B' . $bill->id;
            
            $transaction = $student->transactions()->create([
                'branch_id'    => $student->branch_id,
                'invoice_code' => $invoiceCode,
                'total_amount' => $bill->amount,
                'status'       => 'PAID',
                'payment_url'  => '#',
                'transaction_date' => now(),
                'paid_at'      => now(),
                'payment_method' => 'CASH',
                'payment_channel' => 'MANUAL_BY_ADMIN'
            ]);

            $bill->update([
                'status' => 'PAID',
                'transaction_id' => $transaction->id
            ]);

            // Logic Status Updates
            if ($student->status === 'pending') {
                $student->update(['status' => 'active']);
            }

            // Check if Period Over
            if ($this->studentService->isPeriodOver($student)) {
                 $hasUnpaidBills = $student->bills()->where('status', '!=', 'PAID')->exists();
                 if (!$hasUnpaidBills) {
                     $student->update(['status' => 'inactive']);
                 }
            }

            // Advance next_billing_date agar scheduler tidak membuat ulang tagihan untuk periode yg sama
            $this->advanceNextBillingDate($student, $student->package, $bill->due_date);

            // Send WA
            $this->sendExistingBillPaymentNotification($student, $bill, $senderName);

            return ['success' => true, 'message' => 'Tagihan berhasil dilunaskan secara manual.'];
        });
    }

    // --- Helpers ---

    private function calculateAmount(Student $student, $package)
    {
        $isDailyRate = $package->duration < 30;

        if ($student->billing_cycle === 'weekly') {
            return $isDailyRate ? ($package->price * 7) : ceil($package->price / 4);
        } elseif ($student->billing_cycle === 'daily') {
            return $isDailyRate ? $package->price : ceil($package->price / 30);
        } elseif ($student->billing_cycle === 'monthly') {
            return $isDailyRate ? ($package->price * 30) : $package->price;
        } elseif ($student->billing_cycle === 'full') {
            if ($isDailyRate) {
                return $package->price * $package->duration;
            } else {
                $months = ceil($package->duration / 30);
                return $package->price * ($months > 0 ? $months : 1);
            }
        }
        return $package->price;
    }

    private function advanceNextBillingDate(Student $student, $package, $currentDueDate)
    {
        $nextDate = $currentDueDate->copy();
        if ($student->billing_cycle === 'weekly') {
            $nextDate->addWeek();
        } elseif ($student->billing_cycle === 'daily') {
            $nextDate->addDay();
        } elseif ($student->billing_cycle === 'monthly') {
            $nextDate->addMonth();
        } elseif ($student->billing_cycle === 'full') {
            $nextDate->addMonths($package->duration);
        }
        $student->update(['next_billing_date' => $nextDate]);
    }

    // --- Notification Helpers ---

    private function sendBillNotification(Student $student, string $title, float $amount, string $senderName)
    {
        if (!$student->parent_phone && !$student->name) return;

        try {
            $target = $student->parent_phone;
            $portalLink = $student->portal_link;
            $amountRp = number_format($amount, 0, ',', '.');
            $scheduleLink = route('schedules.index');

            $msg = "🔔 *TAGIHAN BARU DITERBITKAN* 🔔\n\n"
                 . "Halo Orang Tua *{$student->name}*,\n"
                 . "Tagihan baru telah diterbitkan oleh {$senderName}.\n\n"
                 . "📝 *Detail Tagihan:*\n"
                 . "🏷️ Judul: {$title}\n"
                 . "💰 Jumlah: Rp {$amountRp}\n\n"
                 . "Silakan cek dan bayar melalui Portal Siswa:\n"
                 . "👉 Portal: {$portalLink}\n"
                 . "📅 Jadwal: {$scheduleLink}\n\n"
                 . "ℹ️ *Info:* Klik link di atas untuk melihat detail tagihan.\n\n"
                 . "Terima kasih! 🙏";

            if ($target) {
                $this->whatsappService->sendMessage($target, $msg);
            }
        } catch (\Exception $e) {
            Log::error("WA Manual Bill Failed: " . $e->getMessage());
        }
    }

    private function sendManualPaymentNotification(Student $student, string $title, float $amount, string $senderName)
    {
        if (!$student->parent_phone && !$student->name) return;

        try {
            $target = $student->parent_phone;
            $portalLink = $student->portal_link;
            $amountRp = number_format($amount, 0, ',', '.');
            $scheduleLink = route('schedules.index');

             $msg = "✅ *PEMBAYARAN TUNAI DITERIMA!* ✅\n\n"
                  . "Halo Orang Tua *{$student->name}*,\n"
                  . "Pembayaran tunai untuk tagihan *{$title}* telah kami terima ({$senderName}).\n\n"
                  . "💰 Jumlah: Rp {$amountRp}\n"
                  . "✅ Status: *LUNAS*\n\n"
                  . "Bukti pembayaran & jadwal belajar dapat dilihat di Portal Siswa:\n"
                  . "👉 Portal: {$portalLink}\n"
                  . "📅 Jadwal: {$scheduleLink}\n\n"
                  . "Terima kasih! 🙏";

            if ($target) {
                $this->whatsappService->sendMessage($target, $msg);
            }
        } catch (\Exception $e) {
             Log::error("WA Manual Payment Failed: " . $e->getMessage());
        }
    }

    private function sendExistingBillPaymentNotification(Student $student, Bill $bill, string $senderName)
    {
        if (!$student->parent_phone && !$student->name) return;

        try {
            $target = $student->parent_phone;
            $portalLink = $student->portal_link;
            $amountRp = number_format($bill->amount, 0, ',', '.');
            $scheduleLink = route('schedules.index');

            $msg = "✅ *PEMBAYARAN DITERIMA!* ✅\n\n"
                 . "Halo Orang Tua *{$student->name}*,\n"
                 . "Pembayaran untuk tagihan *{$bill->title}* telah diselesaikan secara manual oleh {$senderName}.\n\n"
                 . "💰 Jumlah: Rp {$amountRp}\n"
                 . "✅ Status: *LUNAS*\n\n"
                 . "Bukti pembayaran & jadwal belajar dapat dilihat di Portal Siswa:\n"
                 . "👉 Portal: {$portalLink}\n"
                 . "📅 Jadwal: {$scheduleLink}\n\n"
                 . "Terima kasih! 🙏";

            if ($target) {
                $this->whatsappService->sendMessage($target, $msg);
            }
        } catch (\Exception $e) {
             Log::error("WA Pay Bill Manually Failed: " . $e->getMessage());
        }
    }
}
