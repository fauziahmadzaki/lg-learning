<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request, Branch $branch)
    {
        $search = $request->input('search');

        $packages = Package::where('branch_id', $branch->id)
            ->withCount('students')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%")
                       ->orWhere('category', 'like', "%{$search}%")
                       ->orWhereHas('packageCategory', function($qc) use ($search){
                            $qc->where('name', 'like', "%{$search}%");
                       });
                });
            })
            ->latest()
            ->paginate(10); // Use pagination for branch view
    
        $grades = \App\Models\PackageCategory::pluck('name', 'id');

        if ($request->ajax()) {
            return view('branch.package.partials.table', compact('packages', 'grades', 'branch'))->render();
        }

        return view('branch.package.index', compact('packages', 'grades', 'branch'));
    }

    public function create(Branch $branch)
    {
        $categories = \App\Models\PackageCategory::all();
        return view('branch.package.create', compact('branch', 'categories'));
    }

    public function store(StorePackageRequest $request, Branch $branch)
    {
        DB::transaction(function () use ($request, $branch) {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('packages', 'public');
            }

            Package::create([
                'branch_id'     => $branch->id, // Force Branch ID
                'package_category_id' => $request->package_category_id,
                'name'          => $request->name,
                'category'      => $request->category, 
                // 'grade'         => $request->grade,
                'price'         => $request->price,
                'duration'      => $request->duration * 30, // Convert Bulan ke Hari
                'session_count' => $request->session_count,
                'description'   => $request->description,
                'benefits'      => $request->benefits,
                'image'         => $imagePath,
            ]);
        });

        return redirect()->route('branch.packages.index', $branch)->with('success', 'Paket berhasil dibuat!');
    }

    public function edit(Branch $branch, Package $package)
    {
        if ($package->branch_id !== $branch->id) {
            abort(403);
        }
        
        $categories = \App\Models\PackageCategory::all();

        return view('branch.package.edit', compact('package', 'branch', 'categories'));
    }

    public function update(UpdatePackageRequest $request, Branch $branch, Package $package)
    {
        if ($package->branch_id !== $branch->id) {
            abort(403);
        }

        DB::transaction(function () use ($request, $package) {
            $data = $request->validated(); 
            
            // Remove branch_id from data if present to prevent moving packages
            unset($data['branch_id']);

            if ($request->hasFile('image')) {
                if ($package->image && Storage::disk('public')->exists($package->image)) {
                    Storage::disk('public')->delete($package->image);
                }
                $data['image'] = $request->file('image')->store('packages', 'public');
            }

            // Convert Durasi (Bulan -> Hari)
            if (isset($data['duration'])) {
                $data['duration'] = $data['duration'] * 30;
            }

            $package->update($data);
        });

        return redirect()->route('branch.packages.index', $branch)->with('success', 'Paket diperbarui!');
    }

    public function destroy(Branch $branch, Package $package)
    {
        if ($package->branch_id !== $branch->id) {
            abort(403);
        }

        if ($package->image && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()->route('branch.packages.index', $branch)->with('success', 'Paket berhasil dihapus!');
    }
}
