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
        Schema::table('students', function (Blueprint $table) {
            // 1. Drop Unique Email Constraint (SKIP: Ternyata tidak ada unique index di DB)
            // $table->dropUnique('students_email_unique');

            // 2. Add Package ID (One-to-One / Many-to-One relationship)
            $table->foreignId('package_id')
                  ->nullable() // Nullable dulu biar aman buat data existing
                  ->after('email')
                  ->constrained('packages')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Restore Unique Email
            $table->unique('email');

            // Drop Package ID
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};
