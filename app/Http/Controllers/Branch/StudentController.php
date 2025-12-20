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
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request, Branch $branch)
    {
        $search = $request->input('search');
        $grade = $request->input('grade');
        $packageId = $request->input('package_id');

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
        $grades = array_keys(Package::GRADES ?? ['SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA']);

        if ($request->ajax()) {
            return view('branch.student._list', compact('students', 'branch'))->render();
        }

        return view('branch.student.index', compact('branch', 'students', 'packages', 'grades'));
    }

    public function create(Branch $branch)
    {
        // Only packages from this branch
        $packages = Package::where('branch_id', $branch->id)->with('branch')->get();
        return view('branch.student.create', compact('branch', 'packages'));
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

        $studentService->registerStudent($validatedData, $request->package_id);

        return redirect()->route('branch.students.index', $branch)
            ->with('success', 'Siswa berhasil didaftarkan!');
    }

    public function edit(Branch $branch, Student $student)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }

        $packages = Package::where('branch_id', $branch->id)->with('branch')->get();
        return view('branch.student.edit', compact('branch', 'student', 'packages'));
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

        return redirect()->route('branch.students.index', $branch)
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function show(Branch $branch, Student $student)
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

        return view('branch.student.show', compact('branch', 'student'));
    }

    /**
     * Fitur: Branch Manual Create Bill & Xendit Invoice
     */
    public function storeBill(Request $request, Branch $branch, Student $student)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }
        
        // 1. Pastikan Siswa punya Paket Aktif
        if (!$student->package) {
            return back()->with('error', 'Siswa tidak memiliki paket aktif. Edit siswa untuk pilih paket dulu.');
        }

        if ($student->status === 'pending') {
            return back()->with('error', 'Siswa masih status PENDING (Baru Daftar). Mohon lunasi tagihan pendaftaran pertama dulu sebelum membuat tagihan baru.');
        }

        // 2. Hitung Nominal Tagihan
        $package = $student->package;
        $amount = $package->price; // Default Monthly

        if ($student->billing_cycle === 'weekly') {
            $amount = $package->price / 4;
        } elseif ($student->billing_cycle === 'full') {
            $months = ceil($package->duration / 30);
            $amount = $package->price * ($months > 0 ? $months : 1);
        }

        // 3. Tentukan Due Date
        $dueDate = $student->next_billing_date ?? now();
        $title = "Tagihan " . $package->name . " - Periode " . $dueDate->format('d M Y');

        // 4. Buat Record 'Bill'
        $bill = $student->bills()->create([
            'title'    => $title,
            'amount'   => $amount,
            'due_date' => $dueDate,
            'status'   => 'UNPAID',
        ]);

        // 5. Generate Transaksi & Invoice
        $invoiceCode = 'INV-' . time() . '-' . $student->id . '-B' . $bill->id; // Unique Code
        
        $transaction = $student->transactions()->create([
            'invoice_code' => $invoiceCode,
            'total_amount' => $amount,
            'status'       => 'PENDING',
            'payment_url'  => '#',
            'transaction_date' => now(),
        ]);

        // Call Xendit Service
        $txService = new \App\Services\TransactionService();
        
        $successUrl = route('landing.payment.show', ['invoice_code' => $invoiceCode, 'status' => 'success']);
        $failureUrl = route('student.portal.index', ['token' => $student->access_token]);

        $description = "Pembayaran " . $title;
        $result = $txService->createInvoice($transaction, $student, $description, $successUrl, $failureUrl);

        if ($result['success']) {
            $bill->update([
                'transaction_id' => $transaction->id,
                'status' => 'PENDING'
            ]);
            
            // 6. Update Next Billing Date
            $nextDate = $dueDate->copy();
            if ($student->billing_cycle === 'weekly') {
                $nextDate->addWeek();
            } elseif ($student->billing_cycle === 'monthly') {
                $nextDate->addMonth();
            } elseif ($student->billing_cycle === 'full') {
                $nextDate->addMonths($package->duration);
            }

            $student->update(['next_billing_date' => $nextDate]);

            return back()->with('success', 'Tagihan berhasil dibuat! Invoice Xendit aktif.');
        } else {
            return back()->with('error', 'Tagihan dibuat tapi GAGAL generate Xendit Invoice: ' . $result['message']);
        }
    }

    /**
     * Fitur: Branch Manual Payment
     */
    public function storeManualPayment(Request $request, Branch $branch, Student $student, StudentService $studentService)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }

        if (!$student->package) {
            return back()->with('error', 'Siswa tidak memiliki paket aktif.');
        }

        // 1. Hitung Nominal
        $package = $student->package;
        $amount = $package->price;
        if ($student->billing_cycle === 'weekly') {
            $amount = $package->price / 4;
        } elseif ($student->billing_cycle === 'full') {
            $months = ceil($package->duration / 30);
            $amount = $package->price * ($months > 0 ? $months : 1);
        }

        $dueDate = $student->next_billing_date ?? now();
        $title = "Pembayaran Tunai " . $package->name . " - Periode " . $dueDate->format('d M Y');

        // 2. Buat Transaction (PAID)
        $invoiceCode = 'INV-CASH-' . time() . '-' . $student->id;
        
        $transaction = $student->transactions()->create([
            'invoice_code' => $invoiceCode,
            'total_amount' => $amount,
            'status'       => 'PAID', // Langsung LUNAS
            'payment_url'  => '#',
            'transaction_date' => now(),
            'paid_at'      => now(),
            'payment_method' => 'CASH',
            'payment_channel' => 'BRANCH_MANUAL' // Distinction from Admin
        ]);

        // 3. Buat Bill (PAID)
        $student->bills()->create([
            'title'    => $title,
            'amount'   => $amount,
            'due_date' => $dueDate,
            'status'   => 'PAID',
            'transaction_id' => $transaction->id
        ]);

        // 4. Update Next Billing Date & Status
        $studentService->processPaymentSuccess($student);

        return back()->with('success', 'Pembayaran Tunai berhasil dicatat! Transaksi LUNAS.');
    }

    /**
     * Fitur: Lunaskan Tagihan Tertentu (Bypass Xendit / Bayar Tunai)
     */
    public function payBillManually(Request $request, Branch $branch, Student $student, \App\Models\Bill $bill)
    {
        // Validasi
        if ($student->branch_id !== $branch->id) { abort(403); }
        if ($bill->student_id !== $student->id) { abort(403, 'Tagihan tidak valid.'); }

        if ($bill->status === 'PAID') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        \Illuminate\Support\Facades\DB::transaction(function() use ($student, $bill) {
            // 1. Buat Transaksi Lunas
            $invoiceCode = 'INV-MANUAL-' . time() . '-' . $student->id . '-B' . $bill->id;
            
            $transaction = $student->transactions()->create([
                'invoice_code' => $invoiceCode,
                'total_amount' => $bill->amount,
                'status'       => 'PAID',
                'payment_url'  => '#',
                'transaction_date' => now(),
                'paid_at'      => now(),
                'payment_method' => 'CASH',
                'payment_channel' => 'MANUAL_BY_BRANCH'
            ]);

            // 2. Update Bill
            $bill->update([
                'status' => 'PAID',
                'transaction_id' => $transaction->id
            ]);

            // 3. Logic Status
            if ($student->status === 'pending') {
                $student->update(['status' => 'active']);
            }

            // 4. Cek apakah Siswa Selesai (Logic Status)
            if ($student->package && $student->join_date && $student->next_billing_date) {
                $endDate = $student->join_date->copy()->addDays($student->package->duration);
                $isPeriodOver = $student->next_billing_date->gte($endDate);
                
                $hasUnpaidBills = $student->bills()->where('status', '!=', 'PAID')->exists(); 

                if ($isPeriodOver && !$hasUnpaidBills) {
                    $student->update(['status' => 'finished']);
                }
            }
        });

        return back()->with('success', 'Tagihan berhasil dilunaskan secara manual.');
    }

    public function destroy(Branch $branch, Student $student)
    {
        if ($student->branch_id !== $branch->id) {
            abort(403);
        }
        $student->delete();
        return redirect()->route('branch.students.index', $branch)->with('success', 'Data siswa berhasil dihapus');
    }
}
