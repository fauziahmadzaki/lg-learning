<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\FinancialReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" or "updated" event.
     * We want to capture PAID transactions into FinancialReport.
     */
    public function saved(Transaction $transaction): void
    {
        if ($transaction->status === 'PAID') {
            $this->updateFinancialReport($transaction);
        }
    }

    protected function updateFinancialReport(Transaction $transaction)
    {
        // 1. Tentukan Bulan Laporan (Berdasarkan Tanggal Bayar atau Transaksi)
        $date = $transaction->paid_at ?? $transaction->transaction_date;
        $month = Carbon::parse($date)->startOfMonth()->format('Y-m-d');

        // 2. Ambil Branch & Package dari Student
        $student = $transaction->student;
        if (!$student) return;

        $branchId = $student->branch_id;
        $packageId = $student->package_id; // Opsional, bisa null

        // 3. Find or Create Report
        // Kita buat report per Branch per Bulan.
        $report = FinancialReport::firstOrCreate(
            [
                'branch_id' => $branchId,
                'package_id' => $packageId,
                'month' => $month
            ],
            [
                'total_income' => 0,
                'total_expense' => 0,
                'net_profit' => 0,
                'transaction_count' => 0
            ]
        );

        // 4. Update Values (Increment)
        if ($transaction->wasChanged('status') && $transaction->getOriginal('status') !== 'PAID') {
            $report->increment('total_income', $transaction->total_amount);
            $report->increment('net_profit', $transaction->total_amount); // Asumsi expense 0
            $report->increment('transaction_count');
        } 
        // Jika created langsung PAID (Manual Payment)
        elseif ($transaction->wasRecentlyCreated && $transaction->status === 'PAID') {
            $report->increment('total_income', $transaction->total_amount);
            $report->increment('net_profit', $transaction->total_amount);
            $report->increment('transaction_count');
        }
    }
}
