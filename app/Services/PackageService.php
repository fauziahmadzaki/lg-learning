<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Support\Facades\Storage;

class PackageService
{
    public function searchQuery(array $filters)
    {
        return Package::with(['branch', 'packageCategory'])
            ->withCount('students')
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where(function($sq) use ($v) {
                $sq->where('name', 'like', "%{$v}%")
                  ->orWhere('category', 'like', "%{$v}%")
                  ->orWhereHas('packageCategory', fn($qc) => $qc->where('name', 'like', "%{$v}%"));
            }))
            ->when($filters['category'] ?? null, fn($q, $v) => $q->where('category', $v))
            ->latest();
    }

    public function getCreateData(): array
    {
        return [
            'branches'   => \App\Models\Branch::all(),
            'categories' => \App\Models\PackageCategory::all(),
        ];
    }

    public function getEditData(Package $package): array
    {
        return [
            'package'    => $package,
            'branches'   => \App\Models\Branch::all(),
            'categories' => \App\Models\PackageCategory::all(),
        ];
    }

    public function handleImage($request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('packages', 'public');
        }
        return null;
    }

    public function deleteImage(?string $image): void
    {
        if ($image && Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }
    }
}
