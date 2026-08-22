<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Traits\HandlesBranchScope;
use App\Models\Branch;
use App\Models\Student;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    use HandlesBranchScope;

    public function __construct(
        private ReportService $reportService,
    ) {}

    public function index(Request $request, Branch $branch)
    {
        $filters = $request->only(['period', 'start_date', 'end_date', 'package_id', 'category', 'search']);
        $data = $this->reportService->getFinancialReportData($filters, $branch);

        if ($request->input('action') === 'export') {
            $transactions = $this->reportService->getFinancialQuery($filters, $branch)->latest('paid_at')->get();
            return $this->reportService->exportFinancial(
                $transactions,
                'LAPORAN KEUANGAN - ' . strtoupper($branch->name) . ' - PERIODE ' . strtoupper(Carbon::parse($data['start'])->translatedFormat('d F Y')) . ' - ' . strtoupper(Carbon::parse($data['end'])->translatedFormat('d F Y')),
                'laporan-keuangan-' . $branch->slug . '-' . $data['start']->format('Ymd') . '-' . $data['end']->format('Ymd') . '.xlsx'
            );
        }

        return view('branch.report.index', array_merge($data, [
            'branch'   => $branch,
            'packages' => $this->branchPackages($branch),
        ]));
    }

    public function students(Request $request, Branch $branch)
    {
        $filters = array_merge($request->only(['grade', 'status']), ['branch_id' => $branch->id]);
        $data = $this->reportService->getStudentReportData($filters, $branch);

        if ($request->input('action') === 'export') {
            $title = 'LAPORAN DATA SISWA - ' . strtoupper($branch->name) . ' - PER TANGGAL ' . strtoupper(Carbon::now()->translatedFormat('d F Y'));
            $query = Student::with(['package'])->where('branch_id', $branch->id)
                ->when($filters['grade'] ?? null, fn($q, $v) => $q->where('grade', $v))
                ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v));
            return $this->reportService->exportStudent(
                $query->get(),
                $title,
                'laporan-siswa-' . $branch->slug . '-' . date('Y-m-d') . '.xlsx'
            );
        }

        return view('branch.report.student', array_merge($data, [
            'branch' => $branch,
        ]));
    }
}
