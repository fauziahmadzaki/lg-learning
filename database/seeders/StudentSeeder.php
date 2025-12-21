<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Package;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 50 Siswa (paket dan branch sudah dihandle di Factory)
        Student::factory(50)->create();
    }
}
