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
        Schema::table('tutors', function (Blueprint $table) {
            // Foreign key ke tabel branches
            // nullable() dipakai jaga-jaga kalau ada tutor online/pusat yg tidak terikat cabang fisik
            // constrained() otomatis mencari tabel 'branches' dan id
            $table->foreignId('branch_id')->nullable()->after('user_id')->constrained('branches')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tutors', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
