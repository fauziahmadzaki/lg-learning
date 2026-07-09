<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Student;
use App\Models\Transaction;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(
        private PackagePricingService $pricing,
        private BillingDateService $billingDate,
        private WhatsAppServiceInterface $whatsapp,
        private ?TransactionService $transactionService = null,
    ) {}

    public function checkAndProcessXenditPayment(string $invoiceCode): array
    {
        $transaction = Transaction::where('invoice_code', $invoiceCode)->firstOrFail();

        $processed = DB::transaction(function () use ($transaction, $invoiceCode) {
            $transaction->refresh()->lockForUpdate();

            if ($transaction->status !== 'PENDING') {
                return false;
            }

            $xenditInvoice = $this->transactionService?->getInvoiceStatus($invoiceCode);

            if (!$xenditInvoice || !in_array($xenditInvoice['status'] ?? '', ['PAID', 'SETTLED'])) {
                return false;
            }

            $transaction->update([
                'status' => 'PAID',
                'paid_at' => now(),
                'payment_method' => $xenditInvoice['payment_method'] ?? 'XENDIT',
                'payment_channel' => $xenditInvoice['payment_channel'] ?? 'Unknown',
            ]);

            $this->processPaymentSuccess($transaction->student, $transaction);

            ActivityLogger::log(
                "Pembayaran Berhasil (Xendit Check): {$transaction->student->name} melunasi tagihan {$transaction->invoice_code}",
                $transaction->student
            );

            return true;
        });

        return [
            'processed'   => $processed,
            'message'     => $processed ? 'Status Pembayaran Berhasil Diperbarui!' : '',
            'transaction' => $transaction,
        ];
    }

    public function simulatePayment(string $invoiceCode): void
    {
        $transaction = Transaction::where('invoice_code', $invoiceCode)->firstOrFail();

        $transaction->update([
            'status' => 'PAID',
            'paid_at' => now(),
            'payment_method' => 'SIMULATED_BANK_TRANSFER',
        ]);

        $this->processPaymentSuccess($transaction->student, $transaction, false);

        $transaction->student->update(['status' => 'active']);
    }

    public function processPaymentSuccess(Student $student, ?Transaction $transaction = null, bool $sendNotification = true): void
    {
        $package = $student->package;
        if (!$package) return;

        $baseDate = $student->next_billing_date ?? $student->join_date ?? now();

        if ($transaction) {
            if (!$transaction->relationLoaded('bills')) {
                $transaction->load('bills');
            }
            $bill = $transaction->bills->first();
            if ($bill) {
                $baseDate = $bill->due_date->copy();
            }
        }

        $nextDate = $this->billingDate->advanceNextBillingDate($baseDate, $student->billing_cycle, $package->duration);

        $currentStoredDate = $student->next_billing_date;
        if ($currentStoredDate && $currentStoredDate->gt($nextDate)) {
            $nextDate = $currentStoredDate;
        }

        $endDate = $student->join_date
            ? $this->billingDate->getEndDate($student->join_date, $package)
            : null;

        $status = $endDate && $this->billingDate->isPeriodOver($nextDate, $endDate, $student->billing_cycle)
            ? 'inactive'
            : 'active';

        $student->update([
            'status' => $status,
            'next_billing_date' => $status === 'inactive' ? null : $nextDate,
        ]);

        if ($sendNotification) {
            $this->sendPaymentNotification($student, $transaction, $baseDate, $package, $status);
        }
    }

    public function processManualPayment(Student $student, string $senderName = 'Admin Pusat'): array
    {
        if (!$student->package) {
            return ['success' => false, 'message' => 'Siswa tidak memiliki paket aktif.'];
        }

        if ($student->status === 'inactive') {
            return ['success' => false, 'message' => 'Siswa sudah tidak aktif. Tidak bisa mencatat pembayaran.'];
        }

        $dueDate = $student->next_billing_date ?? now();

        return DB::transaction(function () use ($student, $dueDate, $senderName) {
            $student = Student::where('id', $student->id)->lockForUpdate()->first();
            if (!$student || !$student->package) {
                return ['success' => false, 'message' => 'Siswa tidak memiliki paket aktif.'];
            }

            $package = $student->package;
            $amount = $this->pricing->calculateAmount($package, $student->billing_cycle);
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
                'payment_channel' => 'ADMIN_MANUAL',
            ]);

            $student->bills()->create([
                'branch_id' => $student->branch_id,
                'title'    => $title,
                'amount'   => $amount,
                'due_date' => $dueDate,
                'status'   => 'PAID',
                'transaction_id' => $transaction->id,
            ]);

            $this->processPaymentSuccess($student, $transaction, false);

            $this->sendManualPaymentNotification($student, $title, $amount, $senderName);

            return ['success' => true, 'message' => 'Pembayaran Tunai berhasil dicatat! Transaksi LUNAS.'];
        });
    }

    public function payExistingBill(Student $student, Bill $bill, string $senderName = 'Admin Pusat'): array
    {
        if ($bill->student_id !== $student->id) {
            return ['success' => false, 'message' => 'Tagihan tidak valid untuk siswa ini.'];
        }

        if ($bill->status === 'PAID') {
            return ['success' => false, 'message' => 'Tagihan ini sudah lunas.'];
        }

        return DB::transaction(function () use ($student, $bill, $senderName) {
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
                'payment_channel' => 'MANUAL_BY_ADMIN',
            ]);

            $bill->update([
                'status' => 'PAID',
                'transaction_id' => $transaction->id,
            ]);

            if ($student->status === 'pending') {
                $student->update(['status' => 'active']);
            }

            $nextDate = $this->billingDate->advanceNextBillingDate($bill->due_date, $student->billing_cycle, $student->package?->duration);
            $student->update(['next_billing_date' => $nextDate]);

            if ($student->package && $student->join_date) {
                $endDate = $this->billingDate->getEndDate($student->join_date, $student->package);
                if ($this->billingDate->isPeriodOver($nextDate, $endDate, $student->billing_cycle)) {
                    $hasUnpaidBills = $student->bills()->where('status', '!=', 'PAID')->exists();
                    if (!$hasUnpaidBills) {
                        $student->update(['status' => 'inactive']);
                    }
                }
            }

            $this->sendExistingBillPaymentNotification($student, $bill, $senderName);

            return ['success' => true, 'message' => 'Tagihan berhasil dilunaskan secara manual.'];
        });
    }

    private function sendPaymentNotification(Student $student, ?Transaction $transaction, $baseDate, $package, string $status): void
    {
        if (!$student->parent_phone && !$student->name) return;

        try {
            $target = $student->parent_phone;
            if (!$target) return;

            $invoiceUrl = $transaction
                ? ($transaction->payment_url !== '#'
                    ? $transaction->payment_url
                    : route('landing.payment.show', ['invoice_code' => $transaction->invoice_code, 'status' => 'success']))
                : '-';

            $portalLink = $student->portal_link;
            $scheduleLink = route('schedules.index');

            $msg = "✅ *PEMBAYARAN DITERIMA!* ✅\n\n"
                . "Halo Orang Tua *{$student->name}*,\n"
                . "Pembayaran untuk paket *{$package->name}* periode *{$baseDate->format('d M Y')}* telah berhasil.\n\n"
                . "✅ Status: *LUNAS*\n"
                . "🔗 Invoice: {$invoiceUrl}\n\n"
                . "Bukti pembayaran & jadwal belajar dapat dilihat di Portal Siswa:\n"
                . "👉 Portal: {$portalLink}\n"
                . "📅 Jadwal: {$scheduleLink}\n\n"
                . "Terima kasih! 🙏";

            $this->whatsapp->sendMessage($target, $msg);

            if ($status === 'inactive') {
                $msgFinish = "Selamat {$student->name}!\n\n"
                    . "Anda telah menyelesaikan program {$package->name}.\n"
                    . "Terima kasih telah belajar bersama LG Learning.\n"
                    . "Akses sertifikat/raport di portal: {$portalLink}";

                $this->whatsapp->sendMessage($target, $msgFinish);
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WA in PaymentService: " . $e->getMessage());
        }
    }

    private function sendManualPaymentNotification(Student $student, string $title, float $amount, string $senderName): void
    {
        if (!$student->parent_phone && !$student->name) return;

        try {
            $target = $student->parent_phone;
            if (!$target) return;

            $amountRp = number_format($amount, 0, ',', '.');
            $portalLink = $student->portal_link;
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

            $this->whatsapp->sendMessage($target, $msg);
        } catch (\Exception $e) {
            Log::error("WA Manual Payment Failed: " . $e->getMessage());
        }
    }

    private function sendExistingBillPaymentNotification(Student $student, Bill $bill, string $senderName): void
    {
        if (!$student->parent_phone && !$student->name) return;

        try {
            $target = $student->parent_phone;
            if (!$target) return;

            $amountRp = number_format($bill->amount, 0, ',', '.');
            $portalLink = $student->portal_link;
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

            $this->whatsapp->sendMessage($target, $msg);
        } catch (\Exception $e) {
            Log::error("WA Pay Bill Manually Failed: " . $e->getMessage());
        }
    }
}
