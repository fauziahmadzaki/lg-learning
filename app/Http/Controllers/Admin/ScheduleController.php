<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ClassSchedule;
use App\Models\Package;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Filters
        $branchId = $request->input('branch_id');

        // 2. Fetch Schedules
        $query = ClassSchedule::with(['branch', 'package']);
        
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $schedules = $query->get();

        // 3. Group by Day for Weekly View
        // Structure: ['monday' => [items], 'tuesday' => [items]...]
        $weeklySchedules = [
            'monday' => [], 'tuesday' => [], 'wednesday' => [], 
            'thursday' => [], 'friday' => [], 'saturday' => [], 'sunday' => []
        ];

        foreach ($schedules as $schedule) {
            $day = strtolower($schedule->day_of_week);
            if (isset($weeklySchedules[$day])) {
                $weeklySchedules[$day][] = $schedule;
            }
        }

        // Sort items by Start Time within each day
        foreach ($weeklySchedules as $day => &$items) {
            usort($items, function($a, $b) {
                return strcmp($a->start_time, $b->start_time);
            });
        }

        // 4. Usage Data for Modal
        $branches = Branch::all();
        $packages = Package::all(); // Maybe filter active?

        return view('admin.schedule.index', compact('weeklySchedules', 'branches', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id'   => 'required|exists:branches,id',
            'package_id'  => 'required|exists:packages,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'quota'       => 'nullable|integer|min:1',
        ]);

        ClassSchedule::create($request->all());

        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function destroy(ClassSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
