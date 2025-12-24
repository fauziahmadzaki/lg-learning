<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Specific Logic for Tutor
        if ($request->user()->role === 'tutor') {
            $request->validate([
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
                'jobs' => 'nullable|string', 
                'image' => 'nullable|image|max:2048', // Max 2MB
            ]);

            // Convert comma-separated string to array
            $jobsArray = $request->input('jobs') 
                ? array_map('trim', explode(',', $request->input('jobs'))) 
                : [];

            // Prepare Data
            $tutorData = [
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'bio' => $request->input('bio'),
                'jobs' => $jobsArray,
            ];

            // Handle Image Upload
            if ($request->hasFile('image')) {
                // Get existing tutor profile
                $tutor = $request->user()->tutor;
                
                // Delete old image if exists
                if ($tutor && $tutor->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($tutor->image)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($tutor->image);
                }

                // Store new image
                $path = $request->file('image')->store('tutors', 'public');
                $tutorData['image'] = $path;
            }

            $request->user()->tutor()->updateOrCreate(
                ['user_id' => $request->user()->id],
                $tutorData
            );
        }

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
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
