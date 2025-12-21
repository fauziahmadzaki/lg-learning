<?php

namespace App\Http\Controllers;

use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PackageCategory::latest()->paginate(10);
        return view('admin.package-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.package-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:package_categories,name',
            'slug' => 'nullable|string|max:255|unique:package_categories,slug',
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        PackageCategory::create($validated);

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori Paket berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageCategory $packageCategory)
    {
        return view('admin.package-category.edit', compact('packageCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PackageCategory $packageCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:package_categories,name,' . $packageCategory->id,
            'slug' => 'nullable|string|max:255|unique:package_categories,slug,' . $packageCategory->id,
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $packageCategory->update($validated);

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori Paket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageCategory $packageCategory)
    {
        // Cek dependencies jika perlu (misal: jika masih ada paket yang menggunakan)
        if ($packageCategory->packages()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh Paket. Hapus atau pindahkan paket terlebih dahulu.');
        }

        $packageCategory->delete();

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori Paket berhasil dihapus.');
    }
}
