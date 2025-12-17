<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\TutorSeeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\PackageSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
                    ['email' => 'admin@bimbel.com'], // Cek apakah email ini sudah ada
                    [
                        'name' => 'Super Administrator',
                        'password' => Hash::make('password'), // Password default: password
                        'role' => 'admin', // Pastikan kolom 'role' ada di tabel users Anda
                        'email_verified_at' => now(),
                    ]
                );
        
        $this->call([
            BranchSeeder::class,
            TutorSeeder::class,
            PackageSeeder::class,
        ]);

    }
}
