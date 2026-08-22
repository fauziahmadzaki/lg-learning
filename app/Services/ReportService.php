<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Package;
use App\Models\Student;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;
use App\Exports\StudentExport;

class ReportService
{
    public function getDateRange(string $period, ?string $startDate = null, ?string $endDate = null): array
    {
        $now = Carbon::now();

        $start = match ($period) {
            'custom'    => $startDate ? Carbon::parse($startDate)->startOfDay() : $now->copy()->startOfMonth(),
            'today'     => $now->copy()->startOfDay(),
            'this_week' => $now->copy()->startOfWeek(),
            'last_month' => $now->copy()->subMonth()->startOfMonth(),
            'this_year' => $now->copy()->startOfYear(),
            default     => $now->copy()->startOfMonth(),
        };

        $end = match ($period) {
            'custom'    => $endDate ? Carbon::parse($endDate)->endOfDay() : $now->copy()->endOfMonth(),
            'today'     => $now->copy()->endOfDay(),
            'this_week' => $now->copy()->endOfWeek(),
            'last_month' => $now->copy()->subMonth()->endOfMonth(),
            'this_year' => $now->copy()->endOfYear(),
            default     => $now->copy()->endOfMonth(),
        };

        return compact('start', 'end');
    }

    public function getFinancialQuery(array $filters, ?Branch $branch = null)
    {
        $dateRange = $this->getDateRange(
            $filters['period'] ?? 'this_month',
            $filters['start_date'] ?? null,
            $filters['end_date'] ?? null
        );

        $query = Transaction::query()
            ->with(['student', 'branch', 'package'])
            ->where('status', 'PAID')
            ->where(function ($q) use ($dateRange) {
                $q->whereBetween('paid_at', [$dateRange['start'], $dateRange['end']])
                  ->orWhere(function ($sub) use ($dateRange) {
                      $sub->whereNull('paid_at')->whereBetween('transaction_date', [$dateRange['start'], $dateRange['end']]);
                  });
            });

        if ($branch) {
            $query->whereHas('student', fn($q) => $q->where('branch_id', $branch->id));
        } elseif (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (!empty($filters['package_id'])) {
            $query->whereHas('student', fn($q) => $q->where('package_id', $filters['package_id']));
        }

        $category = $filters['category'] ?? null;
        if ($category === 'spp') {
            $query->where(function ($q) {
                $q->where('type', 'TUITION')->orWhereNull('type');
            });
        } elseif ($category === 'savings') {
            $query->whereIn('type', ['SAVINGS_DEPOSIT', 'SAVINGS_WITHDRAWAL']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('student', fn($s) => $s->where('name', 'like', "%{$search}%"));
            });
        }

        return $query;
    }

    public function getFinancialSummary($transactions): array
    {
        $tuitionTransactions = $transactions->filter(fn($t) => $t->type === 'TUITION' || $t->type === null);
        $tuitionIncome = $tuitionTransactions->sum('total_amount');

        $savingsTransactions = $transactions->where('type', 'SAVINGS_DEPOSIT');
        $savingsIncome = $savingsTransactions->sum('total_amount');

        $withdrawalTransactions = $transactions->where('type', 'SAVINGS_WITHDRAWAL');
        $savingsWithdrawal = $withdrawalTransactions->sum('total_amount');

        $totalIncome = $tuitionIncome + $savingsIncome;
        $transactionCount = $transactions->count();

        $chartData = $tuitionTransactions->groupBy(fn($item) => Carbon::parse($item->paid_at)->format('d M'))
            ->map(fn($group) => $group->sum('total_amount'));

        return compact(
            'tuitionIncome', 'savingsIncome', 'savingsWithdrawal',
            'totalIncome', 'transactionCount', 'chartData'
        );
    }

    public function getFinancialReportData(array $filters, ?Branch $branch = null): array
    {
        $dateRange = $this->getDateRange(
            $filters['period'] ?? 'this_month',
            $filters['start_date'] ?? null,
            $filters['end_date'] ?? null
        );

        $transactions = $this->getFinancialQuery($filters, $branch)
            ->latest('paid_at')
            ->get();

        return array_merge(
            $dateRange,
            ['transactions' => $transactions],
            $this->getFinancialSummary($transactions)
        );
    }

    public function getStudentReportData(array $filters, ?Branch $branch = null): array
    {
        $query = Student::with(['branch', 'package']);

        if ($branch) {
            $query->where('branch_id', $branch->id);
        } elseif (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (!empty($filters['grade'])) {
            $query->where('grade', $filters['grade']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $students = $query->latest()->paginate(20)->withQueryString();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');

        return compact('students', 'grades');
    }

    public function exportFinancial($transactions, string $title, string $filename)
    {
        return Excel::download(new FinancialReportExport($transactions, $title), $filename);
    }

    public function exportStudent($students, string $title, string $filename)
    {
        return Excel::download(new StudentExport($students, $title), $filename);
    }

    public function getFilterBranches()
    {
        return Branch::all();
    }

    public function getFilterPackages()
    {
        return Package::all();
    }
}
