<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;


class BranchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $branches = Branch::query()
            ->withCount(['students', 'tutors', 'packages'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('address', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.branch._list', compact('branches'))->render();
        }

        return view('admin.branch.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branch.create');
    }


    public function store(StoreBranchRequest $request)
    {


        Branch::create($request->validated());

        return redirect()->route('admin.branches.index')
                         ->with('success', 'Cabang berhasil ditambahkan!');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branch.edit', compact('branch'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());

        return redirect()->route('admin.branches.index')
                         ->with('success', 'Data cabang berhasil diperbarui!');
    }

    public function destroy(Branch $branch)
    {
        // dd($branch);
        $branch->delete();


        return redirect()->route('admin.branches.index')
                         ->with('success', 'Cabang berhasil dihapus!');
    }

    public function show(Branch $branch)
    {
        // Summary Counts
        $branch->loadCount(['students', 'tutors', 'packages']);

        // Load Relations
        // 1. Tutors (Relatively few, so get all)
        $tutors = $branch->tutors()->with('user')->get();

        // 2. Packages (Might be many, but manageable list usually)
        $packages = $branch->packages()->withCount('students')->get();

        // 3. Students (Likely many, paginate this)
        $students = $branch->students()
            ->with(['package'])
            ->latest()
            ->paginate(20);

        return view('admin.branch.show', compact('branch', 'tutors', 'packages', 'students'));
    }
}
