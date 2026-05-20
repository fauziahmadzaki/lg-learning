<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tutor;
use App\Models\Branch;
use App\Services\ActivityLogger; // <--- MANUAL LOGGING
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTutorRequest;
use App\Http\Requests\UpdateTutorRequest;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $branchId = $request->input('branch_id');
        $job = $request->input('job');

        $tutors = Tutor::with(['user', 'branch'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('jobs', 'like', "%{$search}%");
            })
            ->when($branchId, function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            })
            ->when($job, function($q) use ($job) {
                // Filter JSON column 'jobs'
                $q->whereJsonContains('jobs', $job);
            })
            ->latest()
            ->paginate(12) // Show 12 cards per page
            ->withQueryString();

        // Data filter
        $branches = Branch::all();
        
        // Ambil semua unique jobs untuk dropdown filter
        // Catatan: Karena kolom JSON, kita bisa ambil simple pluck lalu unique di Collection
        // atau query DB raw jika data sangat besar. Untuk sekarang Collection cukup.
        $allJobs = Tutor::pluck('jobs')->collapse()->unique()->values()->sort();

        if ($request->ajax()) {
            return view('admin.tutor.partials.list', compact('tutors'))->render();
        }

        return view('admin.tutor.index', compact('tutors', 'branches', 'allJobs'));
    }

    public function create()
    {
        $branches = Branch::all(); // Ambil semua cabang
        $packages = \App\Models\Package::with('branch')->get(); // Load semua paket dengan cabang untuk opsi
        return view('admin.tutor.create', compact('branches', 'packages'));
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
                'branch_id' => $request->branch_id,
            ]);
    
            $imagePath = null;
            if ($request->hasFile('image')) {
              
                $imagePath = $request->file('image')->store('tutors', 'public');
            }
    
            // 3. Create Tutor Profile
            $tutor = Tutor::create([
                'user_id' => $user->id,
                'branch_id' => $request->branch_id,
                'address' => $request->address, // Kolom baru
                'phone'   => $request->phone,
                'jobs'    => $request->jobs,    // Masuk sebagai JSON array
                'bio'     => $request->bio,     // Kolom baru
                'image'   => $imagePath,        // Path gambar
            ]);

            // 4. Attach Packages (Relasi Many-to-Many)
            if ($request->has('packages')) {
                $tutor->packages()->attach($request->packages);
            }
        });
    


        // Log Manual - Harus di luar transaction atau ambil data dari request karena $tutor scope terbatas di closure (kecuali di return)
        // Kita bisa log user name dari request
        ActivityLogger::log("Admin mendaftarkan tutor baru: {$request->name}");
    
        return redirect()->route('admin.tutors.index')->with('success', 'Tutor berhasil ditambahkan!');
    }

    public function edit(Tutor $tutor)
    {
        $branches = Branch::all();
        $packages = \App\Models\Package::with('branch')->get();
        $tutor->load('packages'); // Eager load relasi existing
        return view('admin.tutor.edit', compact('tutor', 'branches', 'packages'));
    }

// ... imports tetap sama


    public function update(UpdateTutorRequest $request, Tutor $tutor)
    {
        DB::transaction(function () use ($request, $tutor) {
            
            // 1. Update User
            $userData = [
                'name' => $request->name, 
                'email' => $request->email,
                'branch_id' => $request->branch_id // <--- Correctly update User's branch_id
            ];
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

            // 4. Sync Packages
            // Jika input ada, sync. Jika tidak, detach semua.
            if ($request->has('packages')) {
                $tutor->packages()->sync($request->packages);
            } else {
                $tutor->packages()->detach();
            }
        });



    ActivityLogger::log("Admin memperbarui data tutor: {$tutor->user->name}", $tutor);

    return redirect()->route('admin.tutors.index')->with('success', 'Data tutor diperbarui!');
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



        $name = $tutor->user->name ?? 'Unknown';
        ActivityLogger::log("Admin menghapus tutor: {$name}", $tutor);

        return redirect()->route('admin.tutors.index')->with('success', 'Tutor dihapus!');
    }

    public function show(Tutor $tutor)
    {
        // Load relasi yang diperlukan
        $tutor->load(['user', 'branch', 'packages.branch']);

        return view('admin.tutor.show', compact('tutor'));
    }

}