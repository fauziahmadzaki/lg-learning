<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\StudentService;
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
        // Ambil list grade unik dari konstanta di Model Package, atau hardcode jika perlu
        // Kita pakai yang konsisten dengan PackageController
        $grades = array_keys(Package::GRADES ?? ['SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA']);

        // --- LOGIKA LIVE SEARCH ---
        if ($request->ajax()) {
            return view('admin.student._list', compact('students'))->render();
        }

        return view('admin.student.index', compact('students', 'branches', 'packages', 'grades'));
    }

    public function create()
    {
        $packages = Package::with('branch')->get();
        return view('admin.student.create', compact('packages'));
    }

    public function store(StoreStudentRequest $request, StudentService $studentService)
        {
            $validatedData = $request->safe()->except(['package_id']);
  
            $studentService->registerStudent($validatedData, $request->package_id);

            return redirect()->route('admin.students.index')
                ->with('success', 'Siswa berhasil didaftarkan! Tagihan dan jadwal telah diatur otomatis.');
        }

    public function edit(Student $student)
    {
        $packages = Package::with('branch')->get();
        // $student->load('package'); // Tidak perlu load pivot packages lagi
        return view('admin.student.edit', compact('student', 'packages'));
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

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

   public function show(Student $student)
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

        return view('admin.student.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus');
    }

    /**
     * Fitur: Admin Manual Create Bill & Xendit Invoice
     */
    public function storeBill(Request $request, Student $student)
    {
        // 1. Pastikan Siswa punya Paket Aktif
        if (!$student->package) {
            return back()->with('error', 'Siswa tidak memiliki paket aktif. Edit siswa untuk pilih paket dulu.');
        }

        if ($student->status === 'pending') {
            return back()->with('error', 'Siswa masih status PENDING (Baru Daftar). Mohon lunasi tagihan pendaftaran pertama dulu sebelum membuat tagihan baru.');
        }

        // 2. Hitung Nominal Tagihan (Logic sama dengan Registration)
        $package = $student->package;
        $amount = $package->price; // Default Monthly

        if ($student->billing_cycle === 'weekly') {
            $amount = $package->price / 4;
        } elseif ($student->billing_cycle === 'full') {
            $months = ceil($package->duration / 30);
            $amount = $package->price * ($months > 0 ? $months : 1);
        }

        // 3. Tentukan Due Date (Jatuh Tempo)
        // Gunakan next_billing_date jika ada, atau hari ini
        $dueDate = $student->next_billing_date ?? now();
        // Judul Tagihan
        $title = "Tagihan " . $package->name . " - Periode " . $dueDate->format('d M Y');

        // 4. Buat Record 'Bill' (Tagihan Wajib)
        $bill = $student->bills()->create([
            'title'    => $title,
            'amount'   => $amount,
            'due_date' => $dueDate,
            'status'   => 'UNPAID', // Awalnya UNPAID
        ]);

        // 5. Generate Transaksi & Xendit Invoice Otomatis
        // Agar link langsung muncul di Portal
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
        
        // Redirect URL untuk Xendit (Balik ke Portal biar user biasa lihat status)
        // UPDATE: User minta diarahkan ke Struk Pembayaran (sama seperti daftar awal)
        $successUrl = route('landing.payment.show', ['invoice_code' => $invoiceCode, 'status' => 'success']);
        $failureUrl = route('student.portal.index', ['token' => $student->access_token]);

        $description = "Pembayaran " . $title;
        $result = $txService->createInvoice($transaction, $student, $description, $successUrl, $failureUrl);

        if ($result['success']) {
            // Update Bill dengan Transaction ID
            $bill->update([
                'transaction_id' => $transaction->id,
                'status' => 'PENDING' // Berubah jadi Pending karena sudah ada invoice
            ]);
            
            // 6. Update Next Billing Date Siswa (Advance) - DIHAPUS
            // Jangan advance date saat create Bill, tapi saat Payment Success.
            // Biar ga double advance.
            
            return back()->with('success', 'Tagihan berhasil dibuat! Invoice Xendit aktif.');
        } else {
            // Jika gagal ke Xendit, Bill tetap UNPAID tapi tanpa Link
            return back()->with('error', 'Tagihan dibuat tapi GAGAL generate Xendit Invoice: ' . $result['message']);
        }
    }
    /**
     * Fitur: Admin Manual Payment (Bayar Tunai / Lunas Langsung)
     */
    public function storeManualPayment(Request $request, Student $student, \App\Services\StudentService $studentService)
    {
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
            'payment_channel' => 'ADMIN_MANUAL'
        ]);

        // 3. Buat Bill (PAID)
        $student->bills()->create([
            'title'    => $title,
            'amount'   => $amount,
            'due_date' => $dueDate,
            'status'   => 'PAID',
            'transaction_id' => $transaction->id
        ]);

        // 4. Update Next Billing Date & Status (Via Service)
        $studentService->processPaymentSuccess($student);

        return back()->with('success', 'Pembayaran Tunai berhasil dicatat! Transaksi LUNAS.');
    }

    /**
     * Fitur: Lunaskan Tagihan Tertentu (Bypass Xendit / Bayar Tunai untuk Bill yang sudah ada)
     */
    public function payBillManually(Request $request, Student $student, \App\Models\Bill $bill)
    {
        // Validasi Bill milik Student
        if ($bill->student_id !== $student->id) {
            abort(403, 'Tagihan tidak valid untuk siswa ini.');
        }

        if ($bill->status === 'PAID') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        DB::transaction(function() use ($student, $bill) {
            // 1. Buat Transaksi Lunas
            $invoiceCode = 'INV-MANUAL-' . time() . '-' . $student->id . '-B' . $bill->id;
            
            $transaction = $student->transactions()->create([
                'invoice_code' => $invoiceCode,
                'total_amount' => $bill->amount,
                'status'       => 'PAID',
                'payment_url'  => '#',
                'transaction_date' => now(),
                'paid_at'      => now(),
                'payment_method' => 'CASH',     // Dianggap Tunai
                'payment_channel' => 'MANUAL_BY_ADMIN'
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
            // Cek Period Over & No Unpaid Bills
            if ($student->package && $student->join_date && $student->next_billing_date) {
                // ... logic unchanged ...
                $endDate = $student->join_date->copy()->addDays($student->package->duration);
                $isPeriodOver = $student->next_billing_date->gte($endDate);
                
                // Unpaid count harusnya 0 sekarang (karena baru saja dilunaskan 1)
                $hasUnpaidBills = $student->bills()->where('status', '!=', 'PAID')->exists(); // Pakai query langsung agar real-time

                if ($isPeriodOver && !$hasUnpaidBills) {
                    $student->update(['status' => 'finished']);
                }
            }
        });

        return back()->with('success', 'Tagihan berhasil dilunaskan secara manual.');
    }
}