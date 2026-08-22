<?php

namespace App\Services;

use App\Models\Tutor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TutorService
{
    public function __construct(
        private UserService $userService,
    ) {}

    public function searchQuery(array $filters)
    {
        return Tutor::with(['user', 'branch'])
            ->when($filters['search'] ?? null, function ($q, $v) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$v}%")->orWhere('email', 'like', "%{$v}%"))
                  ->orWhere('jobs', 'like', "%{$v}%");
            })
            ->when($filters['branch_id'] ?? null, fn($q, $v) => $q->where('branch_id', $v))
            ->when($filters['job'] ?? null, fn($q, $v) => $q->whereJsonContains('jobs', $v))
            ->latest();
    }

    public function getFilterData(): array
    {
        return [
            'branches' => \App\Models\Branch::all(),
            'allJobs'  => Tutor::pluck('jobs')->collapse()->unique()->values()->sort(),
        ];
    }

    public function getCreateData(): array
    {
        return [
            'branches' => \App\Models\Branch::all(),
            'packages' => \App\Models\Package::with('branch')->get(),
        ];
    }

    public function getEditData(Tutor $tutor): array
    {
        return [
            'tutor'    => $tutor->load('packages'),
            'branches' => \App\Models\Branch::all(),
            'packages' => \App\Models\Package::with('branch')->get(),
        ];
    }

    public function createTutor(array $data): Tutor
    {
        return DB::transaction(function () use ($data) {
            $user = $this->userService->createUser($data);

            $tutor = Tutor::create([
                'user_id'   => $user->id,
                'branch_id' => $data['branch_id'],
                'address'   => $data['address'] ?? null,
                'phone'     => $data['phone'] ?? null,
                'jobs'      => $data['jobs'] ?? [],
                'bio'       => $data['bio'] ?? null,
                'image'     => $data['image'] ?? null,
            ]);

            if (!empty($data['packages'])) {
                $tutor->packages()->attach($data['packages']);
            }

            return $tutor;
        });
    }

    public function updateTutor(Tutor $tutor, array $data): void
    {
        DB::transaction(function () use ($tutor, $data) {
            $this->userService->updateUser($tutor->user, $data);

            $tutorData = [
                'address'   => $data['address'] ?? $tutor->address,
                'branch_id' => $data['branch_id'] ?? $tutor->branch_id,
                'phone'     => $data['phone'] ?? $tutor->phone,
                'jobs'      => $data['jobs'] ?? $tutor->jobs,
                'bio'       => $data['bio'] ?? $tutor->bio,
            ];

            if (!empty($data['image'])) {
                $tutorData['image'] = $data['image'];
            }

            $tutor->update($tutorData);

            if (array_key_exists('packages', $data)) {
                $tutor->packages()->sync($data['packages'] ?? []);
            }
        });
    }

    public function deleteTutor(Tutor $tutor): void
    {
        DB::transaction(function () use ($tutor) {
            $this->deleteImage($tutor->image);
            $tutor->user->delete();
        });
    }

    public function handleImage($request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('tutors', 'public');
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
