<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
            // 1. Pilih atau buat Paket
            $package = \App\Models\Package::inRandomOrder()->first() ?? \App\Models\Package::factory()->create();

            return [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail, // Hapus unique() agar sesuai dengan logic baru (bisa duplikat email beda paket)
                'parent_phone' => $this->faker->phoneNumber,
                'school' => 'SMA ' . $this->faker->city,
                'grade' => $this->faker->randomElement(['10', '11', '12']),
                'status' => 'active',
                'join_date' => $this->faker->date(),
                
                // 2. Set Paket ID
                'package_id' => $package->id,
                
                // 3. Pastikan Branch ID sama dengan Branch milik Paket
                'branch_id' => $package->branch_id,
                
                'billing_cycle' => 'monthly',
                'access_token' => \Illuminate\Support\Str::random(32),
            ];
    }
}
