<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Student;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\ActivityLogger; // <--- MANUAL LOGGING
use Carbon\Carbon;

class StudentController extends Controller
{
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

        // Data for Filters
        // Only packages from this branch
        $packages = Package::where('branch_id', $branch->id)->get();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');

        if ($request->ajax()) {
            return view('branch.student.partials.table', compact('students', 'branch'))->render();
        }

        return view('branch.student.index', compact('branch', 'students', 'packages', 'grades'));
    }

    public function create(Branch $branch)
    {
        // Only packages from this branch
        $packages = Package::where('branch_id', $branch->id)->with('branch')->get();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');
        return view('branch.student.create', compact('branch', 'packages', 'grades'));
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
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }

        $packages = Package::where('branch_id', $branch->id)->with('branch')->get();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');
        return view('branch.student.edit', compact('branch', 'student', 'packages', 'grades'));
    }

    public function update(UpdateStudentRequest $request, Branch $branch, Student $student, StudentService $studentService)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }

        $studentData = $request->safe()->except(['package_id', 'billing_cycle']);
        
        $studentService->updateStudent(
            $student, 
            $studentData, 
            [] // No package update here to keep simple, modify if needed
        );

        // Log Manual
        ActivityLogger::log("Admin cabang ({$branch->name}) memperbarui data siswa: {$student->name}", $student);

        return redirect()->route('branch.students.index', $branch)
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function show(Branch $branch, Student $student, StudentService $studentService)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }

        $student->load([
            'package',
            'bills' => function($query) {
                $query->orderBy('due_date', 'desc');
            },
            'transactions' => function($query) {
                $query->latest(); 
            }
        ]);

        // Check if Period Over
        $isPeriodOver = $studentService->isPeriodOver($student);

        return view('branch.student.show', compact('branch', 'student', 'isPeriodOver'));
    }

    /**
     * Fitur: Branch Manual Create Bill & Xendit Invoice
     */
    public function storeBill(Request $request, Branch $branch, Student $student, \App\Services\BillingService $billingService)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }
        
        $senderName = "Cabang {$branch->name}";
        $result = $billingService->createNextBill($student, $senderName);

        if ($result['success']) {
            ActivityLogger::log("Admin cabang ({$branch->name}) membuat tagihan manual untuk siswa: {$student->name}", $student);
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Fitur: Branch Manual Payment
     */
    public function storeManualPayment(Request $request, Branch $branch, Student $student, \App\Services\BillingService $billingService)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }

        $senderName = "Cabang {$branch->name}";
        $result = $billingService->processManualPayment($student, $senderName);

        if ($result['success']) {
            ActivityLogger::log("Admin cabang ({$branch->name}) melakukan pembayaran manual untuk siswa: {$student->name}", $student);
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Fitur: Lunaskan Tagihan Tertentu (Bypass Xendit / Bayar Tunai)
     */
    public function payBillManually(Request $request, Branch $branch, Student $student, \App\Models\Bill $bill, \App\Services\BillingService $billingService)
    {
        // Validasi
        if ($student->branch_id !== $branch->id) { abort(403); }
        
        $senderName = "Cabang {$branch->name}";
        $result = $billingService->payExistingBillManually($student, $bill, $senderName);

        if ($result['success']) {
            $invoice = $bill->transaction->invoice_code ?? '-';
            ActivityLogger::log("Admin cabang ({$branch->name}) melunasi tagihan (Invoice: {$invoice}) untuk siswa: {$student->name}", $student);
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Fitur: Tabungan (Deposit) - Branch
     */
    public function storeDeposit(Request $request, Branch $branch, Student $student, \App\Services\SavingService $savingService)
    {
        if ($student->branch_id !== $branch->id) { abort(403); }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $senderName = "Cabang {$branch->name}";
        $result = $savingService->deposit($student, $validated['amount'], $validated['description'], $senderName);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Fitur: Tabungan (Withdraw) - Branch
     */
    public function storeWithdraw(Request $request, Branch $branch, Student $student, \App\Services\SavingService $savingService)
    {
        if ($student->branch_id !== $branch->id) { abort(403); }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $senderName = "Cabang {$branch->name}";
        $result = $savingService->withdraw($student, $validated['amount'], $validated['description'], $senderName);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    public function destroy(Branch $branch, Student $student)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }
        $name = $student->name;
        ActivityLogger::log("Admin cabang ({$branch->name}) menghapus siswa: {$name}", $student);
        $student->delete();
        return redirect()->route('branch.students.index', $branch)->with('success', 'Data siswa berhasil dihapus');
    }
}
