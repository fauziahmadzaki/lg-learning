<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Branch; // <--- Jangan lupa import Model Branch
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil satu ID cabang sebagai default (misal: Unit Kemiri)
        // Pastikan BranchSeeder sudah dijalankan sebelumnya!
        $defaultBranch = Branch::first();

        // Safety check: Jika tabel branches kosong, buat satu dummy
        if (!$defaultBranch) {
            $defaultBranch = Branch::create([
                'name' => 'Unit Pusat',
                'address' => 'Indonesia'
            ]);
        }

        $packages = [
            'Jarimatika',
            'Umum', 
            'English Class',
            'English Class Junior',
            'Pra SD',
            'Jarimatika Privat',
        ];

        foreach ($packages as $name) {
            Package::firstOrCreate([
                'name' => $name
            ], [
                // Assign ke cabang yang ditemukan
                'branch_id' => $defaultBranch->id, 
                
                'price' => 100000, 
                'description' => 'Kelas bimbingan ' . $name,
                'duration' => 30,
                'session_count' => 8
            ]);
        }

        // Generate Random Packages for All Branches
        Package::factory(20)->create();
    }
}