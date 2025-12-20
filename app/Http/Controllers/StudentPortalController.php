<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index($token)
    {
        // 1. Validasi Token
        $student = Student::where('access_token', $token)->firstOrFail();

        // 2. Load Relations (Bills, Transactions, Package)
        $student->load(['bills' => function($q) {
            $q->latest();
        }, 'transactions' => function($q) {
            $q->latest();
        }, 'package', 'branch']);

        // 3. Render View
        return view('student.portal.index', compact('student'));
    }
}
