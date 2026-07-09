<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Traits\HandlesBranchScope;
use App\Models\Branch;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use HandlesBranchScope;

    public function index(Request $request, Branch $branch)
    {
        $search = $request->input('search');

        $query = Transaction::query()
            ->with(['student', 'student.package'])
            ->whereHas('student', fn($q) => $q->where('branch_id', $branch->id));

        if ($search) {
             $query->where(function($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('student', fn($sub) => $sub->where('name', 'like', "%{$search}%"));
             });
        }

        $transactions = $query->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('branch.transaction.partials.table', compact('transactions', 'branch'))->render();
        }

        return view('branch.transaction.index', compact('transactions', 'branch'));
    }

    public function show(Branch $branch, Transaction $transaction)
    {
        $this->authorizeBranch($branch, $transaction);

        return view('admin.transaction.show', compact('transaction'));
    }
}
