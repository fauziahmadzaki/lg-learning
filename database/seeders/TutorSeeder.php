<?php

namespace Database\Seeders;

use App\Models\Tutor;
use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TutorSeeder extends Seeder
{
    public function run(): void
    {
        // Data dari Spreadsheet: Nama, HP, Alamat, dan KELAS YANG DIAMPU (Array)
        $tutors = [
            [
                'name' => 'Heni Safitri S.Psi',
                'phone' => '085815222639',
                'address' => 'Kemiri Pakukerto, Sukorejo',
                'classes' => ['Jarimatika', 'Umum'] // <--- Ini yang akan dihubungkan
            ],
            [
                'name' => 'Nayli Ilfi Amami S.Pd',
                'phone' => '085731072115',
                'address' => 'Kemiri Pakukerto, Sukorejo',
                'classes' => ['Jarimatika']
            ],
            [
                'name' => 'Faizatur Rahmawati S.Psi',
                'phone' => '085536615600',
                'address' => 'Jl. Veteran Kebomas, Gersik',
                'classes' => ['Jarimatika', 'Umum']
            ],
            [
                'name' => 'Cinde Laras Indira S',
                'phone' => '085604197990',
                'address' => 'Karangrejo, Purwosari',
                'classes' => ['Jarimatika', 'Umum']
            ],
            [
                'name' => 'Wartib S.M',
                'phone' => '082231861653',
                'address' => 'Tenggowa Jatiarjo, Prigen',
                'classes' => ['English Class']
            ],
            [
                'name' => 'Silfiatul Badiah S.Pd.i',
                'phone' => '08563558872',
                'address' => 'Tenggowa Jatiarjo, Prigen',
                'classes' => ['English Class Junior', 'Umum']
            ],
            [
                'name' => 'Zahrotul Awalia',
                'phone' => '082338311273',
                'address' => 'Kemiri Pakukerto, Sukorejo',
                'classes' => ['Umum', 'Jarimatika Privat']
            ],
            [
                'name' => 'Lailatul Mufidah',
                'phone' => '082232224347',
                'address' => 'Kemiri Pakukerto, Sukorejo',
                'classes' => ['Pra SD']
            ],
            [
                'name' => 'Aisyah S.Psi',
                'phone' => '088230335620',
                'address' => 'Suco Sukorame, Sukorejo',
                'classes' => ['Jarimatika Privat']
            ],
            [
                'name' => 'Wilda Aulia',
                'phone' => '082142929637',
                'address' => 'Glagasari Sukorejo',
                'classes' => ['Umum']
            ],
        ];

        foreach ($tutors as $data) {
            // 1. Buat User (Akun Login)
            $cleanName = strtolower(preg_replace('/[^a-zA-Z]/', '', $data['name']));
            $email = $cleanName . '@bimbel.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    // 'role' => 'tutor', // Uncomment jika pakai role
                ]
            );

            // 2. Buat Data Tutor
            $tutor = Tutor::create([
                'user_id' => $user->id,
                'phone'   => $data['phone'],
                'address' => $data['address'],
                'jobs'    => ['Tentor Pengajar'], // Default job title
                'bio'     => 'Tentor berpengalaman di bidangnya.', // Default bio
            ]);

            // 3. HUBUNGKAN TUTOR KE PAKET (Pivot)
            foreach ($data['classes'] as $className) {
                // Cari paket berdasarkan nama
                $package = Package::where('name', 'LIKE', "%{$className}%")->first();
                
                if ($package) {
                    // Simpan ke tabel pivot (package_tutor)
                    $tutor->packages()->attach($package->id);
                }
            }
        }
    }
}