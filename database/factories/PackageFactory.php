<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['PRIVATE', 'ROMBEL'];
        $grades = ['SD', 'SMP', 'SMA', 'UTBK', 'UMUM'];

        return [
            'name' => 'Paket ' . $this->faker->word . ' ' . $this->faker->randomElement(['Gold', 'Silver', 'Platinum']),
            'branch_id' => Branch::inRandomOrder()->first()->id ?? Branch::factory(),
            'grade' => $this->faker->randomElement($grades),
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->numberBetween(100, 1000) * 1000, // 100rb - 1jt
            'duration' => 30, // days
            'session_count' => $this->faker->randomElement([4, 8, 12]),
            'description' => $this->faker->sentence,
            'benefits' => [$this->faker->sentence, $this->faker->sentence],
        ];
    }
}
