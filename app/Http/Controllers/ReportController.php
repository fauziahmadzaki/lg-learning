<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\FinancialReport;
use App\Models\Package;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Setup Filters
        $branchId = $request->input('branch_id');
        $packageId = $request->input('package_id');
        
        // Date Filter (Preset or Custom)
        $period = $request->input('period', 'this_month'); // Default This Month
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Logic Date Range
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        if ($period == 'custom' && $startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        } else {
            // Presets
            switch ($period) {
                case 'today':
                    $start = Carbon::today();
                    $end = Carbon::today()->endOfDay();
                    break;
                case 'this_week':
                    $start = Carbon::now()->startOfWeek();
                    $end = Carbon::now()->endOfWeek();
                    break;
                case 'this_month':
                    // Default logic already set above
                    break;
                case 'last_month':
                    $start = Carbon::now()->subMonth()->startOfMonth();
                    $end = Carbon::now()->subMonth()->endOfMonth();
                    break;
                case 'this_year':
                    $start = Carbon::now()->startOfYear();
                    $end = Carbon::now()->endOfYear();
                    break;
                default: // Default This Month
                    $start = Carbon::now()->startOfMonth();
                    $end = Carbon::now()->endOfMonth();
                    break;
            }
        }

        // 2. Query Transactions
        // Hanya ambil yang PAID
        $query = \App\Models\Transaction::query()
            ->with(['student', 'student.branch', 'student.package'])
            ->where('status', 'PAID')
            // Filter Date berdasarkan 'paid_at' (atau transaction_date jika paid_at null, just in case)
            ->where(function($q) use ($start, $end) {
                 $q->whereBetween('paid_at', [$start, $end])
                   ->orWhere(function($sub) use ($start, $end) {
                       $sub->whereNull('paid_at')->whereBetween('transaction_date', [$start, $end]);
                   });
            });

        // Filter Relations
        if ($branchId) {
            $query->whereHas('student', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        if ($packageId) {
             $query->whereHas('student', function($q) use ($packageId) {
                $q->where('package_id', $packageId);
            });
        }

        // Get Data
        $transactions = $query->latest('paid_at')->get();

        // 3. Summaries
        // A. Pemasukan Bimbel (TUITION)
        $tuitionTransactions = $transactions->where('type', 'TUITION')->merge($transactions->whereNull('type')); // Handle legacy
        $tuitionIncome = $tuitionTransactions->sum('total_amount');
        
        // B. Tabungan Masuk (SAVINGS_DEPOSIT)
        $savingsDepositTransactions = $transactions->where('type', 'SAVINGS_DEPOSIT');
        $savingsIncome = $savingsDepositTransactions->sum('total_amount');
        
        // C. Penarikan Tabungan (SAVINGS_WITHDRAWAL)
        $savingsWithdrawalTransactions = $transactions->where('type', 'SAVINGS_WITHDRAWAL');
        $savingsWithdrawal = $savingsWithdrawalTransactions->sum('total_amount');

        // Total Income (Bimbel + Tabungan Masuk - Penarikan?)
        // Usually, Financial Reports show Gross Income.
        // Let's pass them separate.
        $totalIncome = $tuitionIncome + $savingsIncome;
        
        $transactionCount = $transactions->count();
        
        // Net Profit (Assuming Expense is 0 for now, minus Withdrawals?)
        // If "Tabungan" is liability, it shouldn't be profit. 
        // But user asked for "Pemasukan hasil bimbel dan tabungan".
        // Let's just sum them for "Total Cash In". 
        $netProfit = $totalIncome; 

        // Charts Logic (Group by Date) - Focus on Tuition Income for the main chart? Or Total?
        // Let's go with Tuition for consistency with "Earnings".
        $chartData = $tuitionTransactions->groupBy(function($item) {
            return Carbon::parse($item->paid_at)->format('d M');
        })->map(function($group) {
            return $group->sum('total_amount');
        });

        // ACTION: EXPORT EXCEL
        if ($request->input('action') === 'export') {
            $filename = 'laporan-keuangan-' . Carbon::parse($start)->format('Ymd') . '-' . Carbon::parse($end)->format('Ymd') . '.xlsx';
            $exportTransactions = $query->latest('paid_at')->get();
            
            $title = 'LAPORAN KEUANGAN PERIODE ' . strtoupper(Carbon::parse($start)->translatedFormat('d F Y')) . ' - ' . strtoupper(Carbon::parse($end)->translatedFormat('d F Y'));

            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FinancialReportExport($exportTransactions, $title), $filename);
        }

        // Master Data for Filters
        $branches = Branch::all();
        $packages = Package::all();

        return view('admin.report.index', compact(
            'transactions', 
            'totalIncome', 
            'transactionCount', 
            'netProfit', 
            'branches', 
            'packages',
            'chartData',
            'tuitionIncome',
            'savingsIncome',
            'savingsWithdrawal',
            'start', 'end' // Pass date range for UI display
        ));
    }

    public function students(Request $request)
    {
        $query = \App\Models\Student::with(['branch', 'package']);

        // Filters
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        // Action: Export
        if ($request->input('action') === 'export') {
            $filename = 'laporan-siswa-' . date('Y-m-d') . '.xlsx';
            $title = 'LAPORAN DATA SISWA PER TANGGAL ' . strtoupper(Carbon::now()->translatedFormat('d F Y'));
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\StudentExport($query->get(), $title), $filename);
        }

        $students = $query->latest()->paginate(20)->withQueryString();
        $branches = \App\Models\Branch::all();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');

        return view('admin.report.student', compact('students', 'branches', 'grades'));
    }
}
