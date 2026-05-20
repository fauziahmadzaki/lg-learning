<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $query = ActivityLog::with(['user', 'branch'])->latest();

        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($sub) use ($search) {
                      $sub->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        if (request()->ajax()) {
            return view('admin.activity_log.partials.table', compact('logs'))->render();
        }

        return view('admin.activity_log.index', compact('logs'));
    }
}