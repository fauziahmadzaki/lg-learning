<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Transaction;
use App\Services\ActivityLogger; // Re-use our logger
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SavingService
{
    /**
     * Process a savings deposit.
     */
    public function deposit(Student $student, float $amount, ?string $note = null, string $senderName = 'Admin'): array
    {
        if ($amount <= 0) {
            return ['success' => false, 'message' => 'Jumlah deposit harus lebih dari 0.'];
        }

        return DB::transaction(function () use ($student, $amount, $note, $senderName) {
            // 1. Create Transaction (Type: SAVINGS_DEPOSIT)
            $invoiceCode = 'DEP-' . time() . '-' . $student->id;
            
            $transaction = $student->transactions()->create([
                'invoice_code'      => $invoiceCode,
                'total_amount'      => $amount,
                'status'            => 'PAID', // Direct cash deposit is always PAID
                'payment_url'       => '#',
                'type'              => 'SAVINGS_DEPOSIT',
                'description'       => $note,
                'transaction_date'  => now(),
                'paid_at'           => now(),
                'payment_method'    => 'CASH',
                'payment_channel'   => 'MANUAL_DEPOSIT'
            ]);

            // 2. Update Student Balance
            $student->increment('savings_balance', $amount);

            // 3. Log Activity
            ActivityLogger::log("Admin ($senderName) menambah tabungan siswa: {$student->name} sebesar Rp " . number_format($amount, 0, ',', '.'), $student);

            return ['success' => true, 'message' => 'Deposit berhasil ditambahkan.', 'transaction' => $transaction];
        });
    }

    /**
     * Process a savings withdrawal.
     */
    public function withdraw(Student $student, float $amount, ?string $note = null, string $senderName = 'Admin'): array
    {
        if ($amount <= 0) {
            return ['success' => false, 'message' => 'Jumlah penarikan harus lebih dari 0.'];
        }

        if ($student->savings_balance < $amount) {
            return [
                'success' => false, 
                'message' => 'Saldo tidak mencukupi via sistem. Saldo saat ini: Rp ' . number_format($student->savings_balance, 0, ',', '.')
            ];
        }

        return DB::transaction(function () use ($student, $amount, $note, $senderName) {
            // 1. Create Transaction (Type: SAVINGS_WITHDRAWAL)
            // Note: Withdrawals are negative flows conceptually, but stored as positive amount in DB with logic type.
            // Or we store negative? Standard is absolute amount + Type.
            
            $invoiceCode = 'WD-' . time() . '-' . $student->id;
            
            $transaction = $student->transactions()->create([
                'invoice_code'      => $invoiceCode,
                'total_amount'      => $amount, // Store absolute value
                'status'            => 'PAID',
                'payment_url'       => '#',
                'type'              => 'SAVINGS_WITHDRAWAL',
                'description'       => $note,
                'transaction_date'  => now(),
                'paid_at'           => now(),
                'payment_method'    => 'CASH',
                'payment_channel'   => 'MANUAL_WITHDRAWAL'
            ]);

            // 2. Update Student Balance
            $student->decrement('savings_balance', $amount);

            // 3. Log Activity
            ActivityLogger::log("Admin ($senderName) menarik tabungan siswa: {$student->name} sebesar Rp " . number_format($amount, 0, ',', '.'), $student);

            return ['success' => true, 'message' => 'Penarikan berhasil diproses.', 'transaction' => $transaction];
        });
    }
}
