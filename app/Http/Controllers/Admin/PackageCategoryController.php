<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\PackageCategory;
use App\Services\PackageCategoryService;
use App\Http\Requests\StorePackageCategoryRequest;
use App\Http\Requests\UpdatePackageCategoryRequest;

class PackageCategoryController extends Controller
{
    public function __construct(
        private PackageCategoryService $packageCategoryService,
    ) {}

    public function index()
    {
        $categories = PackageCategory::latest()->paginate(10);
        return view('admin.package-category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.package-category.create');
    }

    public function store(StorePackageCategoryRequest $request)
    {
        $this->packageCategoryService->create($request->validated());

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori Paket berhasil ditambahkan.');
    }

    public function edit(PackageCategory $packageCategory)
    {
        return view('admin.package-category.edit', compact('packageCategory'));
    }

    public function update(UpdatePackageCategoryRequest $request, PackageCategory $packageCategory)
    {
        $this->packageCategoryService->update($packageCategory, $request->validated());

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori Paket berhasil diperbarui.');
    }

    public function destroy(PackageCategory $packageCategory)
    {
        if (!$this->packageCategoryService->canDelete($packageCategory)) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh Paket. Hapus atau pindahkan paket terlebih dahulu.');
        }

        $this->packageCategoryService->delete($packageCategory);

        return redirect()->route('admin.package-categories.index')
            ->with('success', 'Kategori Paket berhasil dihapus.');
    }
}
