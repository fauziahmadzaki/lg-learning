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
        // 1. Update Tabel USERS (Untuk Login Admin Cabang/Tutor)
        Schema::table('users', function (Blueprint $table) {
            // Kita set Nullable.
            // Alasannya: Super Admin (Owner) biasanya tidak terikat cabang manapun (Global).
            $table->foreignId('branch_id')->nullable()->after('id')
                  ->constrained('branches')->nullOnDelete(); 
        });

        // 2. Update Tabel STUDENTS (Agar data siswa terisolasi per cabang)
        Schema::table('students', function (Blueprint $table) {
            // Kita set Nullable dulu untuk keamanan jika ada data lama.
            // Tapi nanti saat create siswa baru, ini WAJIB diisi.
            $table->foreignId('branch_id')->nullable()->after('id')
                  ->constrained('branches')->cascadeOnDelete();
        });
        
        // Opsional: Tabel TRANSACTIONS juga perlu jika ingin laporan keuangan terpisah
        Schema::table('transactions', function (Blueprint $table) {
             $table->foreignId('branch_id')->nullable()->after('student_id')
                  ->constrained('branches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop Foreign Key dulu baru kolomnya
            $table->dropForeign(['branch_id']); // Format default laravel: table_column_foreign
            $table->dropColumn('branch_id');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};