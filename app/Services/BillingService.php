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

        $package = $student->package;
        $dueDate = $student->next_billing_date ?? now();

        // 2. Max Bills Check
        $maxBills = 999;
        if ($student->billing_cycle === 'monthly') {
            $maxBills = round($package->duration / 30);
        } elseif ($student->billing_cycle === 'weekly') {
            $maxBills = round($package->duration / 7);
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

        // 4. Duplicate Check
        $existingBill = \App\Models\Bill::where('student_id', $student->id)
                                        ->whereDate('due_date', $dueDate)
                                        ->first();
        if ($existingBill) {
            return ['success' => false, 'message' => "Tagihan untuk periode " . $dueDate->format('d M Y') . " SUDAH ADA."];
        }

        // 5. Calculate Amount
        $amount = $this->calculateAmount($student, $package);
        $title = "Tagihan " . $package->name . " - Periode " . $dueDate->format('d M Y');

        // 6. Create Bill and Transaction (wrapped in Transaction check logic if needed, but not strictly required as Xendit call is external)
        // Note: Controller didn't use DB::transaction for storeBill, but uses it for payBillManually.
        // We will stick to the controller logic order.
        
        $bill = $student->bills()->create([
            'title'    => $title,
            'amount'   => $amount,
            'due_date' => $dueDate,
            'status'   => 'UNPAID',
        ]);

        $invoiceCode = 'INV-' . time() . '-' . $student->id . '-B' . $bill->id;
        
        $transaction = $student->transactions()->create([
            'invoice_code' => $invoiceCode,
            'total_amount' => $amount,
            'status'       => 'PENDING',
            'payment_url'  => '#',
            'transaction_date' => now(),
        ]);

        // 7. Call Xendit Service
        $successUrl = route('landing.payment.show', ['invoice_code' => $invoiceCode, 'status' => 'success']);
        $failureUrl = route('student.portal.index', ['token' => $student->access_token]);
        $description = "Pembayaran " . $title;

        $result = $this->transactionService->createInvoice($transaction, $student, $description, $successUrl, $failureUrl);

        if ($result['success']) {
            // Update Bill with Transaction ID
            $bill->update([
                'transaction_id' => $transaction->id,
                'status' => 'PENDING'
            ]);

            // Update Next Billing Date
            $this->advanceNextBillingDate($student, $package, $dueDate);

            // Send WhatsApp
            $this->sendBillNotification($student, $title, $amount, $senderName);

            return ['success' => true, 'message' => 'Tagihan berhasil dibuat! Invoice Xendit aktif.'];
        } else {
            return ['success' => false, 'message' => 'Tagihan dibuat tapi GAGAL generate Xendit Invoice: ' . $result['message']];
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

        $package = $student->package;
        $amount = $this->calculateAmount($student, $package);
        $dueDate = $student->next_billing_date ?? now();
        $title = "Pembayaran Tunai " . $package->name . " - Periode " . $dueDate->format('d M Y');

        return DB::transaction(function() use ($student, $package, $amount, $dueDate, $title, $senderName) {
            // Create Transaction (PAID)
            
            $invoiceCode = 'INV-CASH-' . time() . '-' . $student->id;
            
            $transaction = $student->transactions()->create([
                'invoice_code' => $invoiceCode,
                'total_amount' => $amount,
                'status'       => 'PAID',
                'payment_url'  => '#',
                'transaction_date' => now(),
                'paid_at'      => now(),
                'payment_method' => 'CASH',
                'payment_channel' => 'ADMIN_MANUAL' // Gets overridden slightly by calls? Or just distinctive.
            ]);

            // Create Bill (PAID)
            $student->bills()->create([
                'title'    => $title,
                'amount'   => $amount,
                'due_date' => $dueDate,
                'status'   => 'PAID',
                'transaction_id' => $transaction->id
            ]);

            // Update Status and Next Billing (using StudentService)
            // Pass false to suppress generic WA, because we send custom one below
            $this->studentService->processPaymentSuccess($student, null, false);

            // Send Custom WA
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

            // Send WA
            $this->sendExistingBillPaymentNotification($student, $bill, $senderName);

            return ['success' => true, 'message' => 'Tagihan berhasil dilunaskan secara manual.'];
        });
    }

    // --- Helpers ---

    private function calculateAmount(Student $student, $package)
    {
        $amount = $package->price;
        if ($student->billing_cycle === 'weekly') {
            $amount = $package->price / 4;
        } elseif ($student->billing_cycle === 'full') {
            $months = ceil($package->duration / 30);
            $amount = $package->price * ($months > 0 ? $months : 1);
        }
        return $amount;
    }

    private function advanceNextBillingDate(Student $student, $package, $currentDueDate)
    {
        $nextDate = $currentDueDate->copy();
        if ($student->billing_cycle === 'weekly') {
            $nextDate->addWeek();
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
