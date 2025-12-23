<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Branch;
use App\Models\Tutor;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $packages = Package::with(['branch', 'packageCategory'])->withCount('students')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('category', 'like', "%{$search}%")
                             ->orWhereHas('packageCategory', function($q) use($search){
                                $q->where('name', 'like', "%{$search}%");
                             });
            })
            // Filter Kategori (Strict)
            ->when($request->category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->latest()
            ->get();
    
        // 2. Ambil daftar Kategori dari DB
        $grades = \App\Models\PackageCategory::pluck('name', 'id');

        if ($request->ajax()) {
            return view('admin.package.partials.table', compact('packages', 'grades'))->render();
        }

        return view('admin.package.index', compact('packages', 'grades'));
    }

    public function create()
    {
        $branches = Branch::all();
        $categories = \App\Models\PackageCategory::all(); // Load dynamic categories
        return view('admin.package.create', compact('branches', 'categories'));
    }

    public function store(StorePackageRequest $request)
    {
        DB::transaction(function () use ($request) {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('packages', 'public');
            }

            Package::create([
                'branch_id'     => $request->branch_id,
                'package_category_id' => $request->package_category_id, // New Column
                'name'          => $request->name,
                'category'      => $request->category, 
                // 'grade'         => $request->grade, // Removed
                'price'         => $request->price,
                'duration'      => $request->duration * 30, // Convert Bulan ke Hari
                'session_count' => $request->session_count,
                'description'   => $request->description,
                'benefits'      => $request->benefits,
                'image'         => $imagePath,
            ]);
        });

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dibuat!');
    }

    public function edit(Package $package)
    {
        $branches = Branch::all();
        $categories = \App\Models\PackageCategory::all();
        
        return view('admin.package.edit', compact('package', 'branches', 'categories'));
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        DB::transaction(function () use ($request, $package) {
            
            // Ambil semua data validasi (termasuk category, name, price, dll)
            $data = $request->validated(); 
            
            // Cek Ganti Gambar
            if ($request->hasFile('image')) {
                // Hapus gambar lama
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

            // Update Relasi Tutor (SYNC)
            // Jika ada input tutors, sync. Jika kosong/null, detach semua.

        });

        return redirect()->route('admin.packages.index')->with('success', 'Paket diperbarui!');
    }

    // PERBAIKAN 3: Method Hapus
    public function destroy(Package $package)
    {
        // Hapus Gambar Fisik
        if ($package->image && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }

        // Hapus Data (Relasi tutor di pivot table otomatis hilang karena onDelete cascade di migration)
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus!');
    }

    public function show(Package $package)
    {
        // Load related data
        $package->load(['branch', 'packageCategory', 'tutors.user']);
        
        $students = $package->students()
            ->with(['branch']) // Eager load branch if needed for display
            ->latest()
            ->paginate(10);

        return view('admin.package.show', compact('package', 'students'));
    }
}