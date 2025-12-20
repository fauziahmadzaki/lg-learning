<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with(['user', 'branch'])
            ->latest()
            ->paginate(20); // Tampilkan 20 baris per halaman

        return view('admin.activity_log.index', compact('logs'));
    }
}