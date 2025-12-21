<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'tutor'])->id,
            'phone' => $this->faker->phoneNumber,
            'jobs' => [$this->faker->randomElement(['Matematika', 'Bahasa Inggris', 'IPA', 'Calistung'])],
            'bio' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'branch_id' => Branch::inRandomOrder()->first()->id ?? Branch::factory(),
        ];
    }
}
