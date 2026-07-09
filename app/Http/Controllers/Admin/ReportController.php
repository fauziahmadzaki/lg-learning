<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Models\Package;
use App\Models\Student;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['period', 'start_date', 'end_date', 'branch_id', 'package_id', 'category', 'search']);
        $data = $this->reportService->getFinancialReportData($filters);

        if ($request->input('action') === 'export') {
            $transactions = $this->reportService->getFinancialQuery($filters)->latest('paid_at')->get();
            return $this->reportService->exportFinancial(
                $transactions,
                'LAPORAN KEUANGAN PERIODE ' . strtoupper(Carbon::parse($data['start'])->translatedFormat('d F Y')) . ' - ' . strtoupper(Carbon::parse($data['end'])->translatedFormat('d F Y')),
                'laporan-keuangan-' . $data['start']->format('Ymd') . '-' . $data['end']->format('Ymd') . '.xlsx'
            );
        }

        return view('admin.report.index', array_merge($data, [
            'branches' => $this->reportService->getFilterBranches(),
            'packages' => $this->reportService->getFilterPackages(),
        ]));
    }

    public function students(Request $request)
    {
        $filters = $request->only(['branch_id', 'grade', 'status']);
        $data = $this->reportService->getStudentReportData($filters);

        if ($request->input('action') === 'export') {
            $query = Student::with(['branch', 'package'])
                ->when($filters['branch_id'] ?? null, fn($q, $v) => $q->where('branch_id', $v))
                ->when($filters['grade'] ?? null, fn($q, $v) => $q->where('grade', $v))
                ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v));
            return $this->reportService->exportStudent(
                $query->get(),
                'LAPORAN DATA SISWA PER TANGGAL ' . strtoupper(Carbon::now()->translatedFormat('d F Y')),
                'laporan-siswa-' . date('Y-m-d') . '.xlsx'
            );
        }

        return view('admin.report.student', array_merge($data, [
            'branches' => $this->reportService->getFilterBranches(),
        ]));
    }
}
