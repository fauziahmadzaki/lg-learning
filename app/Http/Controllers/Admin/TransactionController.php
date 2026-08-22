<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Package;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    public function __construct(
        private \App\Services\TransactionService $transactionService,
    ) {}

    public function index(Request $request)
    {
        $transactions = Transaction::with(['student', 'student.package'])
            ->when($search = $request->input('search'), fn($q, $v) => $q->where(function($sq) use ($v) {
                $sq->where('invoice_code', 'like', "%{$v}%")
                  ->orWhereHas('student', fn($s) => $s->where('name', 'like', "%{$v}%"));
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.transaction.partials.table', compact('transactions'))->render();
        }

        return view('admin.transaction.index', compact('transactions'));
    }

    public function create()
    {
        return view('admin.transaction.create', [
            'students' => Student::all(),
            'packages' => Package::all(),
        ]);
    }

    public function store(StoreTransactionRequest $request)
    {
        $result = $this->transactionService->createTransaction(
            $request->student_id,
            $request->package_id
        );

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
 