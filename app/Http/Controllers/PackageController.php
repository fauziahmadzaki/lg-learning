<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Branch;
use App\Models\Tutor;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
$packages = Package::with('branch')->latest()->get();
    
    // 2. Ambil daftar Grade dari konstanta Model untuk bikin tombol Tabs
    // Kita pakai keys-nya saja (SD, SMP, SMA, dll)
    $grades = array_keys(Package::GRADES);
        return view('package.index', compact('packages', 'grades'));
    }

    public function create()
    {
        $branches = Branch::all();
        $tutors = Tutor::with('user')->get(); 
        return view('package.create', compact('branches', 'tutors'));
    }

    public function store(StorePackageRequest $request)
    {
        DB::transaction(function () use ($request) {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('packages', 'public');
            }

            Package::create([
                'branch_id'     => $request->branch_id,
                'name'          => $request->name,
                // PERBAIKAN 2: Tambahkan category (PRIVATE/ROMBEL)
                'category'      => $request->category, 
                'grade'         => $request->grade,
                'price'         => $request->price,
                'duration'      => $request->duration,
                'session_count' => $request->session_count,
                'description'   => $request->description,
                'benefits'      => $request->benefits,
                'image'         => $imagePath,
            ]);

            // Simpan Relasi Tutor (Many-to-Many)
            if ($request->has('tutors')) {
                // Ambil paket terakhir dibuat utk di-attach
                // Karena Package::create mengembalikan object, lebih aman begini:
                $package = Package::latest()->first(); 
                $package->tutors()->attach($request->tutors);
            }
        });

        return redirect()->route('packages.index')->with('success', 'Paket berhasil dibuat!');
    }

    public function edit(Package $package)
    {
        $branches = Branch::all();
        $tutors = Tutor::with('user')->get();
        
        $package->load('tutors'); 
        
        return view('package.edit', compact('package', 'branches', 'tutors'));
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        DB::transaction(function () use ($request, $package) {
            
            // Ambil semua data validasi (termasuk category, name, price, dll)
            $data = $request->validated(); 
            
            // Cek Ganti Gambar
            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($package->image && Storage::disk('public')->exists($package->image)) {
                    Storage::disk('public')->delete($package->image);
                }
                $data['image'] = $request->file('image')->store('packages', 'public');
            }

            $package->update($data);

            // Update Relasi Tutor (SYNC)
            // Jika ada input tutors, sync. Jika kosong/null, detach semua.
            if ($request->has('tutors')) {
                $package->tutors()->sync($request->tutors);
            } else {
                $package->tutors()->detach();
            }
        });

        return redirect()->route('packages.index')->with('success', 'Paket diperbarui!');
    }

    // PERBAIKAN 3: Method Hapus
    public function destroy(Package $package)
    {
        // Hapus Gambar Fisik
        if ($package->image && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }

        // Hapus Data (Relasi tutor di pivot table otomatis hilang karena onDelete cascade di migration)
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Paket berhasil dihapus!');
    }
}