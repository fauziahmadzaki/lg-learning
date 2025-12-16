<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tutor;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTutorRequest;
use App\Http\Requests\UpdateTutorRequest;

class TutorController extends Controller
{
    public function index()
    {
        // Eager Load 'user' agar tidak N+1 query saat ambil nama & email
        $tutors = Tutor::with('user')->latest()->paginate(10);
        return view('tutor.index', compact('tutors'));
    }

    public function create()
{
    $branches = Branch::all(); // Ambil semua cabang
    return view('tutor.create', compact('branches'));
}

    public function store(StoreTutorRequest $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Create User
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'tutor',
            ]);
    
            // 2. Handle Image Upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                // Simpan ke folder 'tutors' di storage public
                $imagePath = $request->file('image')->store('tutors', 'public');
            }
    
            // 3. Create Tutor Profile
            Tutor::create([
                'user_id' => $user->id,
                'branch_id' => $request->branch_id,
                'address' => $request->address, // Kolom baru
                'phone'   => $request->phone,
                'jobs'    => $request->jobs,    // Masuk sebagai JSON array
                'bio'     => $request->bio,     // Kolom baru
                'image'   => $imagePath,        // Path gambar
            ]);
        });
    
        return redirect()->route('tutors.index')->with('success', 'Tutor berhasil ditambahkan!');
    }

    public function edit(Tutor $tutor)
    {
        $branches = Branch::all();
        return view('tutor.edit', compact('tutor', 'branches'));
    }

// ... imports tetap sama


    public function update(UpdateTutorRequest $request, Tutor $tutor)
    {
        DB::transaction(function () use ($request, $tutor) {
            
            // 1. Update User
            $userData = ['name' => $request->name, 'email' => $request->email];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $tutor->user->update($userData);

            // 2. Siapkan Data Tutor
            $tutorData = [
                'address' => $request->address,
                'branch_id' => $request->branch_id,
                'phone'   => $request->phone,
                'jobs'    => $request->jobs,
                'bio'     => $request->bio,
            ];

            // 3. Handle Ganti Gambar
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($tutor->image && Storage::disk('public')->exists($tutor->image)) {
                    Storage::disk('public')->delete($tutor->image);
                }
                // Upload baru
                $tutorData['image'] = $request->file('image')->store('tutors', 'public');
            }

            $tutor->update($tutorData);
        });

    return redirect()->route('tutors.index')->with('success', 'Data tutor diperbarui!');
    }

    public function destroy(Tutor $tutor)
    {
        DB::transaction(function () use ($tutor) {
            // Hapus file gambar fisik
            if ($tutor->image && Storage::disk('public')->exists($tutor->image)) {
                Storage::disk('public')->delete($tutor->image);
            }
            // Hapus user (Tutor ikut terhapus karena cascade)
            $tutor->user->delete();
        });

        return redirect()->route('tutors.index')->with('success', 'Tutor dihapus!');
    }

}