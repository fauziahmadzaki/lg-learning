<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Services\PackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request, PackageService $service)
    {
        $packages = $service->searchQuery($request->only(['search', 'category']))->get();

        $grades = \App\Models\PackageCategory::pluck('name', 'id');

        if ($request->ajax()) {
            return view('admin.package.partials.table', compact('packages', 'grades'))->render();
        }

        return view('admin.package.index', compact('packages', 'grades'));
    }

    public function create(PackageService $service)
    {
        return view('admin.package.create', $service->getCreateData());
    }

    public function store(StorePackageRequest $request, PackageService $service)
    {
        Package::create([
            'branch_id'          => $request->branch_id,
            'package_category_id' => $request->package_category_id,
            'name'               => $request->name,
            'category'           => $request->category,
            'price'              => $request->price,
            'duration'           => $request->duration,
            'session_count'      => $request->session_count,
            'description'        => $request->description,
            'benefits'           => $request->benefits,
            'image'              => $service->handleImage($request),
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dibuat!');
    }

    public function edit(Package $package, PackageService $service)
    {
        return view('admin.package.edit', $service->getEditData($package));
    }

    public function update(UpdatePackageRequest $request, Package $package, PackageService $service)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $service->deleteImage($package->image);
            $data['image'] = $service->handleImage($request);
        }

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Paket diperbarui!');
    }

    public function destroy(Package $package, PackageService $service)
    {
        $service->deleteImage($package->image);
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus!');
    }

    public function show(Request $request, Package $package)
    {
        $package->load(['branch', 'packageCategory', 'tutors.user']);

        $query = $package->students()->with(['branch']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $totalSavings = (clone $query)->sum('savings_balance');

        $students = $query->latest()->paginate(10)->withQueryString();

        return view('admin.package.show', compact('package', 'students', 'totalSavings'));
    }
}