<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Services\ActivityLogger; // <--- MANUAL LOGGING
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Carbon\Carbon;           // <--- WAJIB: Untuk atur tanggal
use Illuminate\Support\Str; // <--- WAJIB: Untuk generate token acak
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $branchId = $request->input('branch_id');
        $grade = $request->input('grade');
        $packageId = $request->input('package_id');

        $query = Student::query()
            ->with(['branch', 'package']) // Eager load 'package' (singular)
            ->when($search, function ($q, $search) {
                return $q->where(function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                      ->orWhere('school', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($branchId, function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            })
            ->when($grade, function($q) use ($grade) {
                $q->where('grade', $grade);
            })
            ->when($packageId, function($q) use ($packageId) {
                // Filter langsung ke kolom package_id
                $q->where('package_id', $packageId);
            });
            
        // Action: Export (Moved up to use $query before pagination)
        if ($request->input('action') === 'export') {
            $filename = 'laporan-siswa-' . date('Y-m-d') . '.xlsx';
            $title = 'LAPORAN DATA SISWA PER TANGGAL ' . strtoupper(Carbon::now()->translatedFormat('d F Y'));
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\StudentExport($query->get(), $title), $filename);
        }

        $students = $query->latest()
            ->paginate(10)
            ->withQueryString();

        // Data untuk Filter Dropdown
        $branches = \App\Models\Branch::all();
        $packages = Package::all();
        // Ambil list grade unik dari PackageCategory
        $grades = \App\Models\PackageCategory::pluck('name', 'name');

        // --- LOGIKA LIVE SEARCH ---
        if ($request->ajax()) {
            return view('admin.student.partials.table', compact('students'))->render();
        }

        return view('admin.student.index', compact('students', 'branches', 'packages', 'grades'));
    }

    public function create()
    {
        $packages = Package::with('branch')->get();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');
        return view('admin.student.create', compact('packages', 'grades'));
    }

    public function store(StoreStudentRequest $request, StudentService $studentService)
        {
            $validatedData = $request->safe()->except(['package_id']);
  
            $student = $studentService->registerStudent($validatedData, $request->package_id);

            // Log Manual
            ActivityLogger::log("Admin mendaftarkan siswa baru: {$student->name}", $student);

            return redirect()->route('admin.students.index')
                ->with('success', 'Siswa berhasil didaftarkan! Tagihan dan jadwal telah diatur otomatis.');
        }

    public function edit(Student $student)
    {
        $packages = Package::with('branch')->get();
        $grades = \App\Models\PackageCategory::pluck('name', 'name');
        // $student->load('package'); // Tidak perlu load pivot packages lagi
        return view('admin.student.edit', compact('student', 'packages', 'grades'));
    }

    public function update(UpdateStudentRequest $request, Student $student, StudentService $studentService)
    {
        // 1. Ambil data validasi (exclude package_id & billing_cycle)
        $studentData = $request->safe()->except(['package_id', 'billing_cycle']);

        // 2. Delegate ke Service
        // Kirim array kosong untuk package_id agar paket tidak berubah saat Edit
        $studentService->updateStudent(
            $student, 
            $studentData, 
            [] // Empty array = No Package Update
        );

        // Log Manual
        ActivityLogger::log("Admin memperbarui data siswa: {$student->name}", $student);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function show(Student $student, StudentService $studentService)
    {
        $student->load([
            'package', // Load single package
            // Ambil Tagihan, urutkan dari yang jatuh temponya paling baru
            'bills' => function($query) {
                $query->orderBy('due_date', 'desc');
            },
            // Ambil Transaksi, urutkan dari yang terbaru dibuat
            'transactions' => function($query) {
                $query->latest(); 
            }
        ]);

        // Check if Period Over using Service
        $isPeriodOver = $studentService->isPeriodOver($student);

        return view('admin.student.show', compact('student', 'isPeriodOver'));
    }

    public function destroy(Student $student)
    {
        $name = $student->name; // Capture name before delete
        ActivityLogger::log("Admin menghapus siswa: {$name}", $student);
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus');
    }

    /**
     * Fitur: Admin Manual Create Bill & Xendit Invoice
     */
    public function storeBill(Request $request, Student $student, \App\Services\BillingService $billingService)
    {
        $result = $billingService->createNextBill($student);

        if ($result['success']) {
            ActivityLogger::log("Admin membuat tagihan manual untuk siswa: {$student->name}", $student);
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Fitur: Admin Manual Payment (Bayar Tunai / Lunas Langsung)
     */
    public function storeManualPayment(Request $request, Student $student, \App\Services\BillingService $billingService)
    {
        $result = $billingService->processManualPayment($student);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    public function payBillManually(Request $request, Student $student, \App\Models\Bill $bill, \App\Services\BillingService $billingService)
    {
        $result = $billingService->payExistingBillManually($student, $bill);

        if ($result['success']) {
            $invoice = $bill->transaction->invoice_code ?? '-';
            ActivityLogger::log("Admin melunasi tagihan (Invoice: {$invoice}) untuk siswa: {$student->name}", $student);
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Fitur: Tabungan (Deposit)
     */
    public function storeDeposit(Request $request, Student $student, \App\Services\SavingService $savingService)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $result = $savingService->deposit($student, $validated['amount'], $validated['description'], auth()->user()->name);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Fitur: Tabungan (Withdraw)
     */
    public function storeWithdraw(Request $request, Student $student, \App\Services\SavingService $savingService)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string'
        ]);

        $result = $savingService->withdraw($student, $validated['amount'], $validated['description'], auth()->user()->name);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}