<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = [
            [
                'key' => 'contact_instagram',
                'value' => 'https://instagram.com/lglearning',
                'type' => 'text',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_tiktok',
                'value' => 'https://tiktok.com/@lglearning',
                'type' => 'text',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_facebook',
                'value' => 'https://facebook.com/lglearning',
                'type' => 'text',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             // Ensure contact_whatsapp exists if not already (it might be seeded, but good to ensure)
             // We can check existence in a more robust way or just insert updateOrInsert.
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', ['contact_instagram', 'contact_tiktok', 'contact_facebook'])->delete();
    }
};
