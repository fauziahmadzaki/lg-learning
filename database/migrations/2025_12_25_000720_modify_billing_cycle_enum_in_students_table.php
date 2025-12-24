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
        DB::statement("ALTER TABLE students MODIFY COLUMN billing_cycle ENUM('daily', 'weekly', 'monthly', 'full') NOT NULL DEFAULT 'monthly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE students MODIFY COLUMN billing_cycle ENUM('full', 'monthly', 'weekly') NOT NULL DEFAULT 'monthly'");
    }
};
