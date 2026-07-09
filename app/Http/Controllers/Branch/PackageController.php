<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Traits\HandlesBranchScope;
use App\Models\Branch;
use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    use HandlesBranchScope;

    public function index(Request $request, Branch $branch)
    {
        $search = $request->input('search');

        $packages = Package::where('branch_id', $branch->id)
            ->withCount('students')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%")
                       ->orWhere('category', 'like', "%{$search}%")
                       ->orWhereHas('packageCategory', fn($qc) => $qc->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10);

        $grades = \App\Models\PackageCategory::pluck('name', 'id');

        if ($request->ajax()) {
            return view('branch.package.partials.table', compact('packages', 'grades', 'branch'))->render();
        }

        return view('branch.package.index', compact('packages', 'grades', 'branch'));
    }

    public function create(Branch $branch)
    {
        return view('branch.package.create', [
            'branch'     => $branch,
            'categories' => \App\Models\PackageCategory::all(),
        ]);
    }

    public function store(StorePackageRequest $request, Branch $branch)
    {
        DB::transaction(function () use ($request, $branch) {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('packages', 'public');
            }

            Package::create([
                'branch_id'          => $branch->id,
                'package_category_id' => $request->package_category_id,
                'name'               => $request->name,
                'category'           => $request->category,
                'price'              => $request->price,
                'duration'           => $request->duration,
                'session_count'      => $request->session_count,
                'description'        => $request->description,
                'benefits'           => $request->benefits,
                'image'              => $imagePath,
            ]);
        });

        return redirect()->route('branch.packages.index', $branch)->with('success', 'Paket berhasil dibuat!');
    }

    public function edit(Branch $branch, Package $package)
    {
        $this->authorizeBranch($branch, $package);

        return view('branch.package.edit', [
            'package'    => $package,
            'branch'     => $branch,
            'categories' => \App\Models\PackageCategory::all(),
        ]);
    }

    public function update(UpdatePackageRequest $request, Branch $branch, Package $package)
    {
        $this->authorizeBranch($branch, $package);

        DB::transaction(function () use ($request, $package) {
            $data = $request->validated();

            unset($data['branch_id']);

            if ($request->hasFile('image')) {
                if ($package->image && Storage::disk('public')->exists($package->image)) {
                    Storage::disk('public')->delete($package->image);
                }
                $data['image'] = $request->file('image')->store('packages', 'public');
            }

            // duration already in days from form hidden input

            $package->update($data);
        });

        return redirect()->route('branch.packages.index', $branch)->with('success', 'Paket diperbarui!');
    }

    public function destroy(Branch $branch, Package $package)
    {
        $this->authorizeBranch($branch, $package);

        if ($package->image && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()->route('branch.packages.index', $branch)->with('success', 'Paket berhasil dihapus!');
    }
}
