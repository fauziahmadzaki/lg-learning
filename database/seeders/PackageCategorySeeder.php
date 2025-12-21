<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PackageCategory;

class PackageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sekolah Dasar (SD)',
                'slug' => 'sd',
                'description' => 'Bimbingan belajar untuk siswa tingkat SD kelas 1-6.'
            ],
            [
                'name' => 'Sekolah Menengah Pertama (SMP)',
                'slug' => 'smp',
                'description' => 'Bimbingan belajar untuk siswa tingkat SMP kelas 7-9.'
            ],
            [
                'name' => 'Sekolah Menengah Atas (SMA)',
                'slug' => 'sma',
                'description' => 'Bimbingan belajar untuk siswa tingkat SMA kelas 10-12.'
            ],
            [
                'name' => 'Persiapan UTBK / SNBT',
                'slug' => 'utbk',
                'description' => 'Program intensif persiapan masuk Perguruan Tinggi Negeri.'
            ],
            [
                'name' => 'Bahasa Asing / Umum',
                'slug' => 'umum',
                'description' => 'Kelas bahasa dan keterampilan umum untuk segala usia.'
            ],
        ];

        foreach ($categories as $cat) {
            PackageCategory::create($cat);
        }
    }
}
