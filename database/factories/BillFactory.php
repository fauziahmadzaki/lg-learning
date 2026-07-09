<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'title' => 'Tagihan ' . $this->faker->sentence(3),
            'amount' => $this->faker->numberBetween(100, 500) * 1000,
            'due_date' => $this->faker->date(),
            'status' => 'UNPAID',
        ];
    }

    public function paid(): static
    {
        return $this->state(fn(array $attrs) => [
            'status' => 'PAID',
            'transaction_id' => \App\Models\Transaction::factory(),
        ]);
    }

    public function unpaid(): static
    {
        return $this->state(fn(array $attrs) => ['status' => 'UNPAID']);
    }
}
