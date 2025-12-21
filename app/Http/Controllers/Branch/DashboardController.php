<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Package;
use App\Models\Student;
use App\Models\Transaction;
use App\Http\Controllers\Branch\ReportController;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Branch $branch)
    {
        // Stats
        $totalStudents = Student::where('branch_id', $branch->id)->count();
        $activePackages = Package::where('branch_id', $branch->id)->count();
        
        // Income This Month
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $monthlyIncome = Transaction::whereHas('student', function($q) use ($branch) {
                $q->where('branch_id', $branch->id);
            })
            ->where('status', 'PAID')
            ->whereMonth('paid_at', $currentMonth)
            ->whereYear('paid_at', $currentYear)
            ->sum('total_amount');

        // Schedules Today
        $today = strtolower(now()->locale('en')->dayName);
        $todaysSchedules = \App\Models\ClassSchedule::where('branch_id', $branch->id)
            ->where('day_of_week', $today)
            ->with('package')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        return view('branch.dashboard', compact('branch', 'totalStudents', 'activePackages', 'monthlyIncome', 'todaysSchedules'));
    }

    public function courses(Branch $branch)
    {
        $packages = Package::where('branch_id', $branch->id)
            ->withCount(['students as student_count' => function ($query) {
                $query->where('status', 'active');
            }])
            ->latest()
            ->paginate(12);

        return view('branch.courses.index', compact('branch', 'packages'));
    }

    public function courseShow(Branch $branch, Package $package)
    {
        if($package->branch_id !== $branch->id) {
            abort(404);
        }

        $students = $package->students() // Relation defined as student() in Package model
            ->where('branch_id', $branch->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->paginate(20);

        return view('branch.courses.show', compact('branch', 'package', 'students'));
    }

    public function reports(Branch $branch)
    {
        // Forward to the new ReportController to handle stale route cache
        return app(ReportController::class)->index(request(), $branch);
    }
}
