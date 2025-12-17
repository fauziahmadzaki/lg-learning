<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Student;
use Xendit\Configuration;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class TransactionController extends Controller
{
    public function __construct(){
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    }

    public function index(){
        $transactions = Transaction::with(['student', 'package'])->latest()->paginate(10);
        return view('admin.transaction.index', compact('transactions'));
    }

    public function create()
    {
        $students = Student::all();
        $packages = Package::all();
        return view('admin.transaction.create', compact('students', 'packages'));
    }

public function store(Request $request)
    { 
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'package_id' => 'required|exists:packages,id',
        ]);
        
        $student = Student::findOrFail($validated['student_id']);
        $package = Package::findOrFail($validated['package_id']);

        $invoiceCode = 'INV-'.date('Ymd').'-'.Str::upper(Str::random(5));
        $amount = $package->price;

        // 1. Simpan Transaksi Lokal (Status PENDING)
        $transaction = Transaction::create([
            'invoice_code' => $invoiceCode,
            'student_id' => $student->id,
            'package_id' => $package->id,
            'package_name_snapshot' => $package->name,
            'amount' => $amount,
            'transaction_date' => now(),
            'status' => 'PENDING'
        ]);

        // 2. Siapkan Request Xendit
        $createInvoiceRequest = new CreateInvoiceRequest([
            'external_id' => $invoiceCode,
            'amount' => $amount,
            'payer_email' => $student->email,
            'description' => "Pembayaran bimbel paket ".$package->name,
            'invoice_duration' => 86400,
            
            // Redirect URL: User diarahkan ke sini setelah bayar di Xendit
            'success_redirect_url' => route('transactions.show', $transaction),
            'failure_redirect_url' => route('transactions.index'),
            'currency' => 'IDR',
            'reminder_time' => 1
        ]);

        try {
            // 3. Tembak API Xendit
            $apiInstance = new InvoiceApi();
            $xenditInvoice = $apiInstance->createInvoice($createInvoiceRequest);

            // 4. Simpan Link Pembayaran ke Database
            $transaction->payment_url = $xenditInvoice['invoice_url'];
            $transaction->save();

            // 5. Redirect User ke Xendit
            return redirect($xenditInvoice['invoice_url']);

        } catch (\Exception $e) {
            // Jika error, kembalikan ke form dengan pesan
            return back()->with('error', 'Gagal membuat transaksi Xendit: ' . $e->getMessage());
        }
    }
    public function show(Transaction $transaction)
    {
        // Halaman Detail / Thank You Page
        return view('admin.transaction.show', compact('transaction'));
    }

}
 