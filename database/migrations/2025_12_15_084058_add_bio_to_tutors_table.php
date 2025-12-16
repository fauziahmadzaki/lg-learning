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
        // Menambahkan kolom bio (text) setelah kolom jobs agar rapi
        $table->text('bio')->nullable()->after('jobs');
    });
}

public function down(): void
{
    Schema::table('tutors', function (Blueprint $table) {
        $table->dropColumn('bio');
    });
}
};
