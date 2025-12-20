<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Tutor;
use App\Models\Transaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
    
        $totalBranches = Branch::count();
        $activeTutors = Tutor::count();
        
    
        // Total Available Packages (Not sold count)
        $totalPackages = \App\Models\Package::count();

        $revenue = Transaction::where('status', 'PAID')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');


        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Chart Data (Daily Income - Last 7 Days)
        $chartData = Transaction::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('status', 'PAID')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Format for Chart.js
        $chartLabels = $chartData->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $chartValues = $chartData->pluck('total');

        return view('dashboard', compact(
            'totalBranches', 
            'activeTutors', 
            'totalPackages', 
            'revenue', 
            'recentActivities',
            'chartLabels',
            'chartValues'
        ));
    }
}
