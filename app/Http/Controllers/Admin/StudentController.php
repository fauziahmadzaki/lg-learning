<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use App\Services\StudentService;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request, StudentService $service)
    {
        $filters = $request->only(['search', 'branch_id', 'grade', 'package_id']);
        $query = $service->searchQuery($filters);

        if ($request->input('action') === 'export') {
            $title = 'LAPORAN DATA SISWA PER TANGGAL ' . strtoupper(Carbon::now()->translatedFormat('d F Y'));
            return Excel::download(new StudentExport($query->get(), $title), 'laporan-siswa-' . date('Y-m-d') . '.xlsx');
        }

        $students = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.student.partials.table', compact('students'))->render();
        }

        return view('admin.student.index', array_merge(
            compact('students'),
            $service->getFilterData()
        ));
    }

    public function create(StudentService $service)
    {
        return view('admin.student.create', $service->getFilterData());
    }

    public function store(StoreStudentRequest $request, StudentService $studentService)
    {
        $student = $studentService->registerStudent(
            $request->safe()->except(['package_id']),
            $request->package_id
        );

        ActivityLogger::log("Admin mendaftarkan siswa baru: {$student->name}", $student);

        return redirect()->route('admin.students.index')
            ->with('success', 'Siswa berhasil didaftarkan! Tagihan dan jadwal telah diatur otomatis.');
    }

    public function edit(Student $student, StudentService $service)
    {
        return view('admin.student.edit', array_merge(
            compact('student'),
            $service->getFilterData()
        ));
    }

    public function update(UpdateStudentRequest $request, Student $student, StudentService $studentService)
    {
        $studentService->updateStudent($student, $request->safe()->all(), []);

        ActivityLogger::log("Admin memperbarui data siswa: {$student->name}", $student);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function show(Student $student, StudentService $studentService)
    {
        $student->load([
            'package',
            'bills' => fn($q) => $q->orderBy('due_date', 'desc'),
            'transactions' => fn($q) => $q->latest(),
        ]);

        return view('admin.student.show', [
            'student'     => $student,
            'isPeriodOver' => $studentService->isPeriodOver($student),
        ]);
    }

    public function destroy(Student $student)
    {
        ActivityLogger::log("Admin menghapus siswa: {$student->name}", $student);
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus');
    }

    public function storeBill(Request $request, Student $student, \App\Services\BillingService $billingService)
    {
        $result = $billingService->createNextBill($student);

        if ($result['success']) {
            ActivityLogger::log("Admin membuat tagihan manual untuk siswa: {$student->name}", $student);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function storeManualPayment(Request $request, Student $student, \App\Services\BillingService $billingService)
    {
        $result = $billingService->processManualPayment($student);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function payBillManually(Request $request, Student $student, \App\Models\Bill $bill, \App\Services\BillingService $billingService)
    {
        $result = $billingService->payExistingBillManually($student, $bill);

        if ($result['success']) {
            ActivityLogger::log("Admin melunasi tagihan (Invoice: {$bill->transaction?->invoice_code}) untuk siswa: {$student->name}", $student);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function storeDeposit(Request $request, Student $student, \App\Services\SavingService $savingService)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $result = $savingService->deposit($student, $validated['amount'], $validated['description'], auth()->user()->name);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function storeWithdraw(Request $request, Student $student, \App\Services\SavingService $savingService)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $result = $savingService->withdraw($student, $validated['amount'], $validated['description'], auth()->user()->name);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
