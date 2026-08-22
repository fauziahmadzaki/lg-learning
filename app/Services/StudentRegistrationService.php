<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Student;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Str;

class StudentRegistrationService
{
    public function __construct(
        private PackagePricingService $pricing,
        private TransactionService $transactionService,
        private WhatsAppServiceInterface $whatsapp,
        private StudentService $studentService,
    ) {}

    public function registerFromLanding(array $data, Package $package): array
    {
        $student = Student::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'parent_phone' => $data['parent_phone'],
            'school' => $data['school'] ?? null,
            'grade' => $data['grade'] ?? null,
            'status' => 'inactive',
            'join_date' => now(),
            'branch_id' => $package->branch_id,
            'package_id' => $package->id,
            'billing_cycle' => $data['billing_cycle'],
            'access_token' => Str::random(32),
        ]);

        $amount = $this->pricing->calculateAmount($package, $data['billing_cycle']);

        $transaction = $student->transactions()->create([
            'invoice_code' => 'INV-' . time() . '-' . $student->id,
            'student_id' => $student->id,
            'total_amount' => $amount,
            'status' => 'PENDING',
            'payment_url' => '#',
            'transaction_date' => now(),
        ]);

        $this->sendRegistrationNotification($student, $package, $amount);

        $description = "Pendaftaran " . $package->name . " - " . $student->name;
        $successUrl = route('landing.payment.show', [
            'invoice_code' => $transaction->invoice_code,
            'status' => 'success',
        ]);
        $failureUrl = route('packages.index');

        $result = $this->transactionService->createInvoice(
            $transaction, $student, $description, $successUrl, $failureUrl
        );

        return [
            'success' => $result['success'],
            'message' => $result['message'] ?? null,
            'redirect_url' => $result['redirect_url'] ?? null,
            'student' => $student,
            'transaction' => $transaction,
        ];
    }

    public function registerFromAdmin(array $data, int $packageId): Student
    {
        return $this->studentService->registerStudent($data, $packageId);
    }

    private function sendRegistrationNotification(Student $student, Package $package, float $amount): void
    {
        if (!$student->parent_phone) return;

        try {
            $target = $student->parent_phone;
            $portalLink = $student->portal_link;
            $scheduleLink = route('schedules.index');
            $amountRp = number_format($amount, 0, ',', '.');

            $msg = "🔔 *PENDAFTARAN BERHASIL!* 🔔\n\n"
                . "Halo Orang Tua *{$student->name}*,\n"
                . "Terima kasih telah mendaftar di *LG Learning ({$package->name})*.\n\n"
                . "📝 *Detail Pendaftaran:*\n"
                . "👤 Siswa: {$student->name}\n"
                . "📦 Paket: {$package->name}\n"
                . "💰 Total Tagihan: Rp {$amountRp}\n\n"
                . "Silakan selesaikan pembayaran melalui Portal Siswa (Link Otomatis):\n"
                . "👉 Portal: {$portalLink}\n"
                . "📅 Jadwal: {$scheduleLink}\n\n"
                . "ℹ️ *Info:* Portal ini login otomatis (tanpa password), cukup klik link di atas untuk melihat tagihan & jadwal.\n\n"
                . "Terima kasih! 🙏";

            $this->whatsapp->sendMessage($target, $msg);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send WA registration: " . $e->getMessage());
        }
    }
}
