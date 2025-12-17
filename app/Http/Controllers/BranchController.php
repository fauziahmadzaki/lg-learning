<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;


class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->paginate(10);

        return view('admin.branch.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branch.create');
    }


    public function store(StoreBranchRequest $request)
    {


        Branch::create($request->validated());

        return redirect()->route('branches.index')
                         ->with('success', 'Cabang berhasil ditambahkan!');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branch.edit', compact('branch'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());

        return redirect()->route('branches.index')
                         ->with('success', 'Data cabang berhasil diperbarui!');
    }

    public function destroy(Branch $branch)
    {
        // dd($branch);
        $branch->delete();


        return redirect()->route('branches.index')
                         ->with('success', 'Cabang berhasil dihapus!');
    }
}
