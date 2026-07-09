<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Traits\HandlesBranchScope;
use App\Models\Branch;
use App\Models\ClassSchedule;
use App\Models\Package;
use App\Models\Student;
use App\Models\Transaction;
use App\Http\Controllers\Branch\ReportController;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use HandlesBranchScope;

    public function index(Branch $branch)
    {
        $totalStudents = Student::where('branch_id', $branch->id)->count();
        $activePackages = Package::where('branch_id', $branch->id)->count();

        $monthlyIncome = Transaction::whereHas('student', fn($q) => $q->where('branch_id', $branch->id))
            ->where('status', 'PAID')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('total_amount');

        $packages = Package::where('branch_id', $branch->id)
            ->withCount(['students as active_students_count' => fn($q) => $q->where('status', 'active')])
            ->latest()
            ->limit(6)
            ->get();

        $todaysSchedules = ClassSchedule::where('branch_id', $branch->id)
            ->where('day_of_week', strtolower(now()->format('l')))
            ->with(['package.tutors.user'])
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        return view('branch.dashboard', compact('branch', 'totalStudents', 'activePackages', 'monthlyIncome', 'todaysSchedules', 'packages'));
    }

    public function courses(Branch $branch)
    {
        $packages = Package::where('branch_id', $branch->id)
            ->withCount(['students as student_count' => fn($q) => $q->where('status', 'active')])
            ->latest()
            ->paginate(12);

        return view('branch.courses.index', compact('branch', 'packages'));
    }

    public function courseShow(Request $request, Branch $branch, Package $package)
    {
        $this->authorizeBranch($branch, $package);

        $query = $package->students()
            ->where('branch_id', $branch->id)
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status));

        $totalSavings = (clone $query)->sum('savings_balance');

        $students = $query->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('branch.courses.show', compact('branch', 'package', 'students', 'totalSavings'));
    }

    public function reports(Branch $branch)
    {
        return app(ReportController::class)->index(request(), $branch);
    }


    public function profile(Branch $branch)
    {
        $tutor = \App\Models\Tutor::where('user_id', auth()->id())->first();

        if (!$tutor) {
           return redirect()->route('branch.dashboard', $branch)->with('error', 'Profil tutor tidak ditemukan.');
        }

        $tutor->load(['user', 'branch', 'packages.branch']);

        return view('branch.profile', compact('branch', 'tutor'));
    }

    public function schedules(Branch $branch)
    {
        $schedules = ClassSchedule::where('branch_id', $branch->id)
            ->with(['package.tutors.user'])
            ->orderByRaw("FIELD(day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return view('branch.schedules.index', compact('branch', 'schedules'));
    }
}
