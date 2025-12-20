<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $transactions = Transaction::with(['student', 'student.package']) // Eager load relations
            ->when($search, function ($query, $search) {
                $query->where('invoice_code', 'like', "%{$search}%")
                      ->orWhereHas('student', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.transaction._list', compact('transactions'))->render();
        }

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
        
        $result = $this->transactionService->createTransaction($validated['student_id'], $validated['package_id']);

        if ($result['success']) {
            return redirect($result['redirect_url']);
        }

        return back()->with('error', 'Gagal membuat transaksi Xendit: ' . $result['message']);
    }

    public function show(Transaction $transaction)
    {
        return view('admin.transaction.show', compact('transaction'));
    }

}
 