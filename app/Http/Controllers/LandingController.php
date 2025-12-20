<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Package;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        // Data untuk Hero/Stats
        $stats = [
            'students' => Student::count(),
            'tutors'   => Tutor::count(),
            'branches' => Branch::count(),
            'packages' => Package::count(),
        ];

        // Data Paket (Tampilkan 3 paket unggulan/terbaru)
        // Idealnya ada flag 'is_featured', tapi kita ambil random atau latest dulu
        $packages = Package::withCount('students')->latest()->take(3)->get();

        // Data Tutor (Tampilkan 4 tutor secara random)
        $tutors = Tutor::inRandomOrder()->take(4)->get();

        // Data Kegiatan / Testimoni (Static for now)
        // Data Kegiatan / Testimoni (Dynamic)
        $contents = \App\Models\Content::latest()->get();
        
        // Filter Carousel Only based on checkbox
        $carousel_slides = $contents->where('is_carousel', true)->map(function($item) {
             return [
                'image' => $item->image_url,
                'title' => $item->title,
                'description' => $item->description,
                'type' => $item->type
            ];
        })->values();

        // Activities (Dynamically from Content table)
        // We can filter by type 'activity' if needed, or use all non-carousel contents.
        $activities = $contents->where('type', 'activity');
        
        // Use fallbacks if empty
        if ($activities->isEmpty()) {
             $activities = collect([
                (object)[
                    'image_url' => 'https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=1000&auto=format&fit=crop',
                    'title' => 'Kelas Intensif UTBK',
                    'description' => 'Persiapan matang menuju PTN impian dengan tutor ahli.',
                    'type'  => 'Kegiatan'
                ],
             ]);
        }
        
        // Restore missing data fetching
        $packages = \App\Models\Package::with('branch')->get();
        $tutors = \App\Models\Tutor::with('user')->limit(4)->get(); 
        
        // Carousel Slides
        $carousel_slides = \App\Models\Content::where('is_carousel', true)->latest()->get()->map(function($item) {
            return [
                'image' => $item->image_url,
                'title' => $item->title,
                'description' => $item->description,
                'type' => $item->type
            ];
        }); 

        // Fetch Site Settings
        $settings = \App\Models\SiteSetting::pluck('value', 'key');

        return view('landing.index', compact('stats', 'packages', 'tutors', 'activities', 'carousel_slides', 'settings'));
    }

    public function tutors()
    {
        $tutors = \App\Models\Tutor::with('user', 'branch')->paginate(12);
        $settings = \App\Models\SiteSetting::pluck('value', 'key');
        
        return view('landing.tutors.index', compact('tutors', 'settings'));
    }

    public function packages()
    {
        // Data untuk Filter
        $branches = Branch::all();
        $grades   = Package::select('grade')->distinct()->whereNotNull('grade')->pluck('grade');
        // Kategori bisa diambil dari field 'category' atau hardcode jika belum konsisten
        // Di migrasi sebelumnya: $table->string('category')->nullable();
        $categories = Package::select('category')->distinct()->whereNotNull('category')->pluck('category');

        // Ambil SEMUA paket (untuk Client-side filtering) atau Paginate (untuk Server-side)
        // User minta "Live Search", paling enak Client-side kalau data dikit.
        // Kita preload slug untuk routing.
        $packages = Package::with('branch')->get(); 

        return view('landing.packages.index', compact('packages', 'branches', 'grades', 'categories'));
    }

    public function showPackage(Package $package)
    {
        // Load relasi
        $package->load(['branch', 'tutors']);

        // Tampilkan detail paket
        return view('landing.packages.show', compact('package'));
    }

    public function registrationForm(Package $package)
    {
        return view('landing.registration.form', compact('package'));
    }

    public function storeRegistration(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email', // Removed unique:students check to allow returning students or simple duplications for now
            'phone'      => 'required|numeric',
            'parent_phone' => 'nullable|numeric',
            'school'     => 'nullable|string',
            'grade'      => 'nullable|string',
            'address'    => 'nullable|string',
            'billing_cycle' => 'required|in:weekly,monthly,full',
        ]);

        $package = Package::findOrFail($request->package_id);

        // 1. Create Student (Inactive)
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email, // Email might be duplicated if we don't enforce unique. Using it for contact.
            'parent_phone' => $request->parent_phone ?? $request->phone, // Fallback to student phone
            'school' => $request->school,
            'grade'  => $request->grade,
            'address' => $request->address,
            'status' => 'inactive', // Default inactive until paid
            'join_date' => now(),
            'branch_id' => $package->branch_id, // Inherit branch from package
            'package_id' => $package->id,
            'billing_cycle' => $request->billing_cycle,
            'access_token' => \Illuminate\Support\Str::random(32), // Generate Magic Link Token
        ]);

        // 2. Calculate Amount
        $amount = $package->price; // Default Monthly
        if ($request->billing_cycle === 'weekly') {
            $amount = $package->price / 4; // Simple logic
        } elseif ($request->billing_cycle === 'full') {
            $months = ceil($package->duration / 30);
            $amount = $package->price * ($months > 0 ? $months : 1);
        }

        // 3. Create Transaction (Pending)
        $transaction = \App\Models\Transaction::create([
            'invoice_code' => 'INV-' . time() . '-' . $student->id,
            'student_id'   => $student->id,
            'total_amount' => $amount,
            'status'       => 'PENDING',
            'payment_url'  => '#', // Placeholder, will be updated by PaymentService
            'transaction_date' => now(),
        ]);

        // 4. Call Payment Service (Real Xendit)
        $txService = new \App\Services\TransactionService();
        $description = "Pendaftaran " . $package->name . " - " . $student->name;
        
        // Setup Redirect URLs
        // Setelah bayar sukses di Xendit, user diarahkan kembali ke sini dengan query param status=success
        $successUrl = route('landing.payment.show', [
            'invoice_code' => $transaction->invoice_code,
            'status' => 'success'
        ]);
        $failureUrl = route('landing.packages.index'); // Atau halaman lain jika gagal

        $result = $txService->createInvoice($transaction, $student, $description, $successUrl, $failureUrl);

        if (!$result['success']) {
            // Jika gagal create invoice Xendit
            return back()->with('error', 'Gagal membuat tagihan pembayaran: ' . $result['message']);
        }

        // Redirect ke Url Xendit
        return redirect($result['redirect_url']);
    }

    public function showPayment($invoice_code, \App\Services\TransactionService $txService, \App\Services\StudentService $studentService)
    {
        $transaction = \App\Models\Transaction::where('invoice_code', $invoice_code)->firstOrFail();
        
        // Cek Status Pembayaran ke Xendit jika local status masih PENDING
        if ($transaction->status === 'PENDING') {
            
            // Coba cek ke Xendit (terutama jika baru redirect kembali dg status success)
            $xenditInvoice = $txService->getInvoiceStatus($invoice_code);

            if ($xenditInvoice && ($xenditInvoice['status'] === 'PAID' || $xenditInvoice['status'] === 'SETTLED')) {
                // Update Local Data
                DB::transaction(function() use ($transaction, $xenditInvoice, $studentService) {
                    $transaction->update([
                        'status' => 'PAID',
                        'paid_at' => now(),
                        'payment_method' => $xenditInvoice['payment_method'] ?? 'XENDIT',
                        'payment_channel' => $xenditInvoice['payment_channel'] ?? 'Unknown'
                    ]);
                    
                    // Activate Student Logic
                    $studentService->processPaymentSuccess($transaction->student);
                });

                session()->flash('success', 'Status Pembayaran Berhasil Diperbarui!');
                $transaction->refresh();
            }
        }
        
        // Cek jika ada parameter sukses dari redirect Xendit
        if (request('status') === 'success') {
            session()->flash('success', 'Pembayaran Berhasil! Terima kasih.');
        }

        // Jika sudah lunas, tetap tampilkan halaman ini (Mode Struk Pembayaran)
        // View sudah menghandle tampilan status 'PAID'
        return view('landing.payment.show', compact('transaction'));
    }

    public function processPayment(Request $request)
    {
        // SIMULASI WEBHOOK XENDIT
        $transaction = \App\Models\Transaction::where('invoice_code', $request->invoice_code)->firstOrFail();

        // 1. Update Transaksi
        $transaction->update([
            'status' => 'PAID',
            'paid_at' => now(),
            'payment_method' => 'SIMULATED_BANK_TRANSFER',
        ]);

        // 2. Activate Student
        $student = $transaction->student;
        
        // Calculate Next Billing Date
        $nextDate = now();
        if ($student->billing_cycle === 'weekly') {
            $nextDate->addWeek();
        } elseif ($student->billing_cycle === 'monthly') {
            $nextDate->addMonth();
        } elseif ($student->billing_cycle === 'full') {
            $nextDate->addMonths($student->package->duration);
        }

        $student->update([
            'status' => 'active',
            'next_billing_date' => $nextDate,
        ]);

        return redirect()->route('home')->with('success', 'Pembayaran Berhasil! Siswa telah aktif.');
    }
}
