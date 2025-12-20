<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_code' => 'INV-' . $this->faker->unique()->numerify('#####'),
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory(),
            'total_amount' => $this->faker->numberBetween(100, 500) * 1000,
            'status' => $this->faker->randomElement(['PAID', 'PENDING', 'EXPIRED', 'FAILED']),
            'payment_method' => 'Bant Transfer',
            'payment_channel' => 'BCA',
            'paid_at' => $this->faker->dateTimeThisMonth(),
            'transaction_date' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
