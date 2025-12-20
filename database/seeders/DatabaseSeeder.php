<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\TutorSeeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\TransactionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Central Admin
        User::updateOrCreate(
            ['email' => 'admin@bimbel.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Branches (Real + Fake)
        $this->call(BranchSeeder::class);
        $branches = Branch::all();

        // 3. Create Branch Managers (Users) for each branch
        foreach($branches as $branch) {
            $email = strtolower(str_replace(' ', '', $branch->name)) . '@bimbel.com';
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Admin ' . $branch->name,
                    'password' => Hash::make('password'),
                    'role' => 'admin', // Role sebagai Branch Admin
                    'branch_id' => $branch->id,
                    'email_verified_at' => now(),
                ]
            );
        }

        // 4. Seed Other Data
        // PackageSeeder needs to run BEFORE StudentSeeder
        $this->call([
            TutorSeeder::class,   // Tutors
            PackageSeeder::class, // Packages
            StudentSeeder::class, // Students + Attach Package
            TransactionSeeder::class, // Transactions
        ]);

        echo "Seeding Complete! \n";
        echo "Admin Pusat: admin@bimbel.com / password \n";
        echo "Contoh Admin Cabang: " . strtolower(str_replace(' ', '', $branches->first()->name)) . "@bimbel.com / password \n";
    }
}
