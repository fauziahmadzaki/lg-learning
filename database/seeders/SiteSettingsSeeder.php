<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // GENERAL / IDENTITY
            [
                'key' => 'site_logo',
                'value' => null, // Default null, will use fallback in view
                'type' => 'image',
                'group' => 'general',
                'hint' => 'Upload logo website (Format: PNG/JPG). Jika kosong, akan menggunakan logo default.'
            ],

            // HERO SECTION
            [
                'key' => 'hero_title',
                'value' => 'Raih Masa Depan Gemilang Bersama LG Learning',
                'type' => 'text',
                'group' => 'hero',
                'hint' => 'Judul utama di halaman depan.'
            ],
            [
                'key' => 'hero_description',
                'value' => 'Bimbingan belajar terbaik dengan metode fun learning yang terbukti meningkatkan prestasi siswa.',
                'type' => 'textarea',
                'group' => 'hero',
                'hint' => 'Deskripsi singkat di bawah judul.'
            ],
            [
                'key' => 'hero_button_text',
                'value' => 'Daftar Sekarang',
                'type' => 'text',
                'group' => 'hero',
                'hint' => 'Teks tombol aksi utama.'
            ],
            [
                'key' => 'hero_image',
                'value' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'type' => 'image',
                'group' => 'hero',
                'hint' => 'Ukuran rekomendasi: 800x600px atau rasio 4:3. Format: JPG/PNG.'
            ],
            [
                'key' => 'hero_badge_title',
                'value' => 'Hasil Terjamin',
                'type' => 'text',
                'group' => 'hero',
                'hint' => 'Judul kecil di badge hero image.'
            ],
            [
                'key' => 'hero_badge_subtitle',
                'value' => 'Nilai Naik',
                'type' => 'text',
                'group' => 'hero',
                'hint' => 'Teks besar di badge hero image.'
            ],

            // FAQ SECTION
            [
                'key' => 'faq_data',
                'value' => json_encode([
                    [
                        'question' => 'Apakah ada garansi nilai naik?',
                        'answer' => 'Ya, kami memberikan garansi kenaikan nilai dengan syarat siswa mengikuti minimal 90% sesi pembelajaran.'
                    ],
                    [
                        'question' => 'Berapa jumlah siswa per kelas?',
                        'answer' => 'Untuk menjaga kualitas, kelas reguler maksimal 10 siswa. Untuk kelas privat, 1 siswa 1 tutor.'
                    ],
                    [
                        'question' => 'Apakah bisa ganti jadwal?',
                        'answer' => 'Bisa. Pengajuan perubahan jadwal maksimal H-1 sebelum sesi dimulai.'
                    ]
                ]),
                'type' => 'json_list',
                'group' => 'faq',
                'hint' => 'Kelola daftar pertanyaan dan jawaban.'
            ],

            // ABOUT SECTION
            [
                'key' => 'about_title',
                'value' => 'Mengapa Memilih LG Learning?',
                'type' => 'text',
                'group' => 'about'
            ],
            [
                'key' => 'about_description',
                'value' => 'Kami berkomitmen mencetak generasi cerdas dan berkarakter melalui metode pembelajaran yang adaptif dan menyenangkan. Didukung oleh tentor berpengalaman dari PTN ternama.',
                'type' => 'textarea',
                'group' => 'about'
            ],

            // FEATURES SECTION (Cards)
            [
                'key' => 'feature_1_title',
                'value' => 'Metode Personal',
                'type' => 'text',
                'group' => 'features'
            ],
            [
                'key' => 'feature_1_desc',
                'value' => 'Setiap anak unik. Kami menyesuaikan pendekatan belajar sesuai dengan gaya dan kecepatan belajar siswa.',
                'type' => 'textarea',
                'group' => 'features'
            ],
            [
                'key' => 'feature_2_title',
                'value' => 'Tutor Selektif',
                'type' => 'text',
                'group' => 'features'
            ],
            [
                'key' => 'feature_2_desc',
                'value' => 'Tutor kami tidak hanya pintar akademis, tapi juga sabar dan mampu memotivasi siswa untuk berprestasi.',
                'type' => 'textarea',
                'group' => 'features'
            ],
            [
                'key' => 'feature_3_title',
                'value' => 'Laporan Berkala',
                'type' => 'text',
                'group' => 'features'
            ],
            [
                'key' => 'feature_3_desc',
                'value' => 'Pantau perkembangan anak Anda dengan laporan progress yang detail dan transparan setiap bulannya.',
                'type' => 'textarea',
                'group' => 'features'
            ],

            // CONTACT SECTION
            [
                'key' => 'contact_whatsapp',
                'value' => '6281234567890',
                'type' => 'text',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Pendidikan No. 123, Jakarta Selatan',
                'type' => 'text',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@lglearning.com',
                'type' => 'text',
                'group' => 'contact'
            ],
             [
                'key' => 'contact_instagram',
                'value' => '@lg_learning',
                'type' => 'text',
                'group' => 'contact'
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
