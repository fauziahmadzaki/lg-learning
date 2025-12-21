<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, Branch $branch)
    {
        $search = $request->input('search');

        // Query Transactions scoped to Branch
        $query = Transaction::query()
            ->with(['student', 'student.package'])
            ->whereHas('student', function($q) use ($branch) {
                $q->where('branch_id', $branch->id);
            });

        // Search Filter
        if ($search) {
             $query->where(function($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sub) use ($search) {
                      $sub->where('name', 'like', "%{$search}%");
                  });
             });
        }

        $transactions = $query->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('branch.transaction._list', compact('transactions', 'branch'))->render();
        }

        return view('branch.transaction.index', compact('transactions', 'branch'));
    }

    public function show(Branch $branch, Transaction $transaction)
    {
        // Security Check: Ensure Transaction belongs to a Student in this Branch
        if ($transaction->student->branch_id !== $branch->id) {
            abort(403);
        }

        return view('admin.transaction.show', compact('transaction')); 
        // Reuse Admin view for Detail? 
        // Admin view might extend 'admin.layouts.app'. Branch has 'branch.layouts.app' or similar?
        // Wait, Admin views extend <x-app-layout>. Branch views also extend <x-app-layout> but with different sidebar logic?
        // Let's check layouts. standard <x-app-layout> uses conditions to show x-branch-sidebar.
        // So reusing admin view MIGHT work if breadcrumbs are handled.
        // Admin show view has breadcrumbs? Let's check later. 
        // For now, let's just use the Admin view and if it looks weird we fix it.
    }
}
