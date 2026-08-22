<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Traits\HandlesBranchScope;
use App\Models\Branch;
use App\Models\Student;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\ActivityLogger;
use Carbon\Carbon;

class StudentController extends Controller
{
    use HandlesBranchScope;
    public function index(Request $request, Branch $branch)
    {
        $search = $request->input('search');
        $grade = $request->input('grade');
        $packageId = $request->input('package_id');
        $status = $request->input('status');

        $query = Student::query()
            ->where('branch_id', $branch->id) // SCOPED
            ->with(['package'])
            ->when($search, function ($q, $search) {
                return $q->where(function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                      ->orWhere('school', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($grade, function($q) use ($grade) {
                $q->where('grade', $grade);
            })

            ->when($packageId, function($q) use ($packageId) {
                $q->where('package_id', $packageId);
            });
            
        // Export Logic
        if ($request->input('action') === 'export') {
            $filename = 'laporan-siswa-' . Str::slug($branch->name) . '-' . date('Y-m-d') . '.xlsx';
            $title = 'DATA SISWA CABANG ' . strtoupper($branch->name) . ' PER ' . strtoupper(Carbon::now()->translatedFormat('d F Y'));
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\StudentExport($query->get(), $title), $filename);
        }

        $students = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $packages = $this->branchPackages($branch);
        $grades = $this->getGrades();

        if ($request->ajax()) {
            return view('branch.student.partials.table', compact('students', 'branch'))->render();
        }

        return view('branch.student.index', compact('branch', 'students', 'packages', 'grades'));
    }

    public function create(Branch $branch)
    {
        return view('branch.student.create', [
            'branch'   => $branch,
            'packages' => $this->branchPackages($branch),
            'grades'   => $this->getGrades(),
        ]);
    }

    public function store(StoreStudentRequest $request, Branch $branch, StudentService $studentService)
    {
        // Force branch_id
        $request->merge(['branch_id' => $branch->id]);
        
        $validatedData = $request->safe()->except(['package_id']);
        // Add branch_id to validated data manually since it might not be in the form
        $validatedData['branch_id'] = $branch->id;

        // Validation for branch ownership of package
        $package = Package::find($request->package_id);
        if ($package && $package->branch_id !== $branch->id) {
            return back()->with('error', 'Paket tidak valid untuk cabang ini.');
        }

        $student = $studentService->registerStudent($validatedData, $request->package_id);
 
        // Log Manual
        ActivityLogger::log("Admin cabang ({$branch->name}) mendaftarkan siswa baru: {$student->name}", $student);

        return redirect()->route('branch.students.index', $branch)
            ->with('success', 'Siswa berhasil didaftarkan!');
    }

    public function edit(Branch $branch, Student $student)
    {
        $this->authorizeBranch($branch, $student);

        return view('branch.student.edit', [
            'branch'  => $branch,
            'student' => $student,
            'packages' => $this->branchPackages($branch),
            'grades'  => $this->getGrades(),
        ]);
    }

    public function update(UpdateStudentRequest $request, Branch $branch, Student $student, StudentService $studentService)
    {
        $this->authorizeBranch($branch, $student);

        $studentData = $request->safe()->except(['package_id', 'billing_cycle']);
        
        $studentService->updateStudent($student, $studentData, []);

        ActivityLogger::log("Admin cabang ({$branch->name}) memperbarui data siswa: {$student->name}", $student);

        return redirect()->route('branch.students.index', $branch)
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function show(Branch $branch, Student $student, StudentService $studentService)
    {
        $this->authorizeBranch($branch, $student);

        $student->load([
            'package',
            'bills' => fn($q) => $q->orderBy('due_date', 'desc'),
            'transactions' => fn($q) => $q->latest(),
        ]);

        return view('branch.student.show', [
            'branch'      => $branch,
            'student'     => $student,
            'isPeriodOver' => $studentService->isPeriodOver($student),
        ]);
    }

    /**
     * Fitur: Branch Manual Create Bill & Xendit Invoice
     */
    public function storeBill(Request $request, Branch $branch, Student $student, \App\Services\BillingService $billingService)
    {
        $this->authorizeBranch($branch, $student);
        
        $result = $billingService->createNextBill($student, "Cabang {$branch->name}");

        if ($result['success']) {
            ActivityLogger::log("Admin cabang ({$branch->name}) membuat tagihan manual untuk siswa: {$student->name}", $student);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function storeManualPayment(Request $request, Branch $branch, Student $student, \App\Services\BillingService $billingService)
    {
        $this->authorizeBranch($branch, $student);

        $result = $billingService->processManualPayment($student, "Cabang {$branch->name}");

        if ($result['success']) {
            ActivityLogger::log("Admin cabang ({$branch->name}) melakukan pembayaran manual untuk siswa: {$student->name}", $student);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function payBillManually(Request $request, Branch $branch, Student $student, \App\Models\Bill $bill, \App\Services\BillingService $billingService)
    {
        $this->authorizeBranch($branch, $student);
        
        $result = $billingService->payExistingBillManually($student, $bill, "Cabang {$branch->name}");

        if ($result['success']) {
            $invoice = $bill->transaction->invoice_code ?? '-';
            ActivityLogger::log("Admin cabang ({$branch->name}) melunasi tagihan (Invoice: {$invoice}) untuk siswa: {$student->name}", $student);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function storeDeposit(Request $request, Branch $branch, Student $student, \App\Services\SavingService $savingService)
    {
        $this->authorizeBranch($branch, $student);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $result = $savingService->deposit($student, $validated['amount'], $validated['description'], "Cabang {$branch->name}");

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function storeWithdraw(Request $request, Branch $branch, Student $student, \App\Services\SavingService $savingService)
    {
        $this->authorizeBranch($branch, $student);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $result = $savingService->withdraw($student, $validated['amount'], $validated['description'], "Cabang {$branch->name}");

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function destroy(Branch $branch, Student $student)
    {
        $this->authorizeBranch($branch, $student);

        ActivityLogger::log("Admin cabang ({$branch->name}) menghapus siswa: {$student->name}", $student);
        $student->delete();
        return redirect()->route('branch.students.index', $branch)->with('success', 'Data siswa berhasil dihapus');
    }
}
