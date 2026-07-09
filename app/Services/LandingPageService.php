<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\ClassSchedule;
use App\Models\Content;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\SiteSetting;
use App\Models\Student;
use App\Models\Tutor;

class LandingPageService
{
    public function getStats(): array
    {
        return [
            'students' => max(40, Student::count()),
            'tutors'   => Tutor::count(),
            'branches' => Branch::count(),
            'packages' => Package::count(),
        ];
    }

    public function getPackages()
    {
        return Package::with(['branch', 'packageCategory'])->get();
    }

    public function getTutors()
    {
        return Tutor::with('user')->limit(4)->get();
    }

    public function getCarouselSlides()
    {
        return Content::where('is_carousel', true)->latest()->get()->map(function ($item) {
            return [
                'image' => $item->image_url,
                'title' => $item->title,
                'description' => $item->description,
                'type' => $item->type,
            ];
        })->values();
    }

    public function getActivities()
    {
        $activities = Content::latest()->get()->where('type', 'activity');

        if ($activities->isEmpty()) {
            $activities = collect([
                (object) [
                    'image_url' => 'https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=1000&auto=format&fit=crop',
                    'title' => 'Kelas Intensif UTBK',
                    'description' => 'Persiapan matang menuju PTN impian dengan tutor ahli.',
                    'type'  => 'Kegiatan',
                ],
            ]);
        }

        return $activities;
    }

    public function getSettings()
    {
        return SiteSetting::pluck('value', 'key');
    }

    public function getTutorsPaginated()
    {
        return Tutor::with('user', 'branch')->paginate(12);
    }

    public function getPackagesPageData(): array
    {
        $branches = Branch::all();
        $grades   = PackageCategory::pluck('name', 'slug');
        $categories = Package::select('category')->distinct()->whereNotNull('category')->pluck('category');
        $packages   = Package::with(['branch', 'packageCategory'])->get();
        $settings   = $this->getSettings();

        return compact('packages', 'branches', 'grades', 'categories', 'settings');
    }

    public function getGallery(?string $type)
    {
        $query = Content::whereNotNull('image');

        if ($type === 'Testimoni') {
            $query->where('type', 'Testimoni');
        } elseif ($type === 'Kegiatan') {
            $query->whereIn('type', ['Kegiatan', 'Galeri']);
        } else {
            $query->whereIn('type', ['Kegiatan', 'Galeri', 'Testimoni']);
        }

        return $query->latest()->paginate(12)->withQueryString();
    }

    public function loadPackageRelations(Package $package): Package
    {
        return $package->load(['branch', 'tutors']);
    }

    public function getContactData(): array
    {
        return [
            'settings' => $this->getSettings(),
            'branches' => Branch::all(),
        ];
    }

    public function getSchedules()
    {
        return ClassSchedule::with(['branch', 'package'])
            ->get()
            ->sortBy(function ($schedule) {
                $days = ['monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 7];
                return [$days[strtolower($schedule->day_of_week)] ?? 8, $schedule->start_time];
            });
    }
}
