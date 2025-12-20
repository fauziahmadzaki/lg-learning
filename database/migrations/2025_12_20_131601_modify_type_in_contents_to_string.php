<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert is risky if data exists outside enum, but for now we try
        Schema::table('contents', function (Blueprint $table) {
            //$table->enum('type', ['Kegiatan', 'Testimoni'])->change();
        });
    }
};
