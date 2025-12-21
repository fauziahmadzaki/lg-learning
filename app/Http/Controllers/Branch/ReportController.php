<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;
use App\Exports\StudentExport;

class ReportController extends Controller
{
    public function index(Request $request, Branch $branch)
    {
        // 1. Setup Filters
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
                    // Default logic
                    break;
                case 'last_month':
                    $start = Carbon::now()->subMonth()->startOfMonth();
                    $end = Carbon::now()->subMonth()->endOfMonth();
                    break;
                case 'this_year':
                    $start = Carbon::now()->startOfYear();
                    $end = Carbon::now()->endOfYear();
                    break;
                default: 
                    $start = Carbon::now()->startOfMonth();
                    $end = Carbon::now()->endOfMonth();
                    break;
            }
        }

        // 2. Query Transactions (Scoped to Branch)
        $query = Transaction::query()
            ->with(['student', 'student.package'])
            ->whereHas('student', function($q) use ($branch) {
                $q->where('branch_id', $branch->id);
            })
            ->where('status', 'PAID')
            ->where(function($q) use ($start, $end) {
                 $q->whereBetween('paid_at', [$start, $end])
                   ->orWhere(function($sub) use ($start, $end) {
                       $sub->whereNull('paid_at')->whereBetween('transaction_date', [$start, $end]);
                   });
            });

        // Filter Package
        if ($packageId) {
             $query->whereHas('student', function($q) use ($packageId) {
                $q->where('package_id', $packageId);
            });
        }

        // Get Data
        $transactions = $query->latest('paid_at')->get();

        // 3. Summaries
        $totalIncome = $transactions->sum('total_amount');
        $transactionCount = $transactions->count();
        $netProfit = $totalIncome; 

        // Charts Logic
        $chartData = $transactions->groupBy(function($item) {
            return Carbon::parse($item->paid_at)->format('d M');
        })->map(function($group) {
            return $group->sum('total_amount');
        });

        // ACTION: EXPORT EXCEL
        if ($request->input('action') === 'export') {
            $filename = 'laporan-keuangan-' . $branch->slug . '-' . Carbon::parse($start)->format('Ymd') . '-' . Carbon::parse($end)->format('Ymd') . '.xlsx';
            
            $title = 'LAPORAN KEUANGAN - ' . strtoupper($branch->name) . ' - PERIODE ' . strtoupper(Carbon::parse($start)->translatedFormat('d F Y')) . ' - ' . strtoupper(Carbon::parse($end)->translatedFormat('d F Y'));

            return Excel::download(new FinancialReportExport($transactions, $title), $filename);
        }

        // Master Data for Filters
        $packages = Package::where('branch_id', $branch->id)->get();

        return view('branch.report.index', compact(
            'branch',
            'transactions', 
            'totalIncome', 
            'transactionCount', 
            'netProfit', 
            'packages',
            'chartData',
            'start', 'end'
        ));
    }

    public function students(Request $request, Branch $branch)
    {
        $query = Student::with(['package'])
            ->where('branch_id', $branch->id);

        // Filters
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }
        
        if ($request->filled('status')) {
             $query->where('status', $request->status);
        }

        // Removed search filter block as per instruction
        // if ($request->filled('search')) {
        //     $query->where('name', 'like', "%{$request->search}%");
        // }

        // Action: Export
        if ($request->input('action') === 'export') {
            $filename = 'laporan-siswa-' . $branch->slug . '-' . date('Y-m-d') . '.xlsx';
            $title = 'LAPORAN DATA SISWA - ' . strtoupper($branch->name) . ' - PER TANGGAL ' . strtoupper(Carbon::now()->translatedFormat('d F Y'));
            return Excel::download(new StudentExport($query->get(), $title), $filename);
        }

        $students = $query->latest()->paginate(20)->withQueryString();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');

        return view('branch.report.student', compact('branch', 'students', 'grades'));
    }
}
