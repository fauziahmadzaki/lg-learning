<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\TutorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private TutorService $tutorService,
    ) {}

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if ($request->user()->role === 'tutor') {
            $tutorData = [
                'phone'   => $request->input('phone'),
                'address' => $request->input('address'),
                'bio'     => $request->input('bio'),
                'jobs'    => $request->input('jobs')
                    ? array_map('trim', explode(',', $request->input('jobs')))
                    : [],
            ];

            $image = $this->tutorService->handleImage($request);
            if ($image) {
                $tutor = $request->user()->tutor;
                if ($tutor && $tutor->image) {
                    $this->tutorService->deleteImage($tutor->image);
                }
                $tutorData['image'] = $image;
            }

            $request->user()->tutor()->updateOrCreate(
                ['user_id' => $request->user()->id],
                $tutorData
            );
        }

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
