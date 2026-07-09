<?php

namespace App\Services;

use App\Models\PackageCategory;

class PackageCategoryService
{
    public function create(array $data): PackageCategory
    {
        return PackageCategory::create([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(PackageCategory $category, array $data): void
    {
        $category->update([
            'name'        => $data['name'] ?? $category->name,
            'slug'        => $data['slug'] ?? $category->slug,
            'description' => $data['description'] ?? $category->description,
        ]);
    }

    public function delete(PackageCategory $category): void
    {
        $category->delete();
    }

    public function canDelete(PackageCategory $category): bool
    {
        return $category->packages()->count() === 0;
    }
}
