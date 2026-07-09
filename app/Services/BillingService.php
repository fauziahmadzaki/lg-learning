<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Student;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingService
{
    protected $paymentService;
    protected $transactionService;
    protected $whatsappService;
    protected $pricing;
    protected $billingDate;

    public function __construct(
        PaymentService $paymentService,
        TransactionService $transactionService,
        WhatsAppServiceInterface $whatsappService,
        PackagePricingService $pricing,
        BillingDateService $billingDate,
    ) {
        $this->paymentService = $paymentService;
        $this->transactionService = $transactionService;
        $this->whatsappService = $whatsappService;
        $this->pricing = $pricing;
        $this->billingDate = $billingDate;
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
                $nextDate = $this->billingDate->advanceNextBillingDate($dueDate, $student->billing_cycle, $package->duration);
                $student->update(['next_billing_date' => $nextDate]);
                return ['success' => false, 'message' => "Tagihan untuk periode " . $dueDate->format('d M Y') . " SUDAH ADA. Sistem telah memperbarui tanggal tagihan berikutnya. Silakan coba buat lagi."];
            }

            // 5. Calculate Amount
            $amount = $this->pricing->calculateAmount($package, $student->billing_cycle);
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

            $nextDate = $this->billingDate->advanceNextBillingDate($dueDate, $student->billing_cycle, $package->duration);
            $student->update(['next_billing_date' => $nextDate]);

            $this->sendBillNotification($student, $title, $amount, $senderName);

            return ['success' => true, 'message' => 'Tagihan berhasil dibuat! Invoice Xendit aktif.'];
        } else {
            return ['success' => false, 'message' => 'Tagihan dibuat tapi GAGAL generate Xendit Invoice: ' . $xenditResult['message']];
        }
    }

    public function processManualPayment(Student $student, string $senderName = 'Admin Pusat'): array
    {
        return $this->paymentService->processManualPayment($student, $senderName);
    }

    public function payExistingBillManually(Student $student, Bill $bill, string $senderName = 'Admin Pusat'): array
    {
        return $this->paymentService->payExistingBill($student, $bill, $senderName);
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

}
