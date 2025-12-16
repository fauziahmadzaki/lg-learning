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
        Schema::table('packages', function (Blueprint $table) {
            $table->json('benefits')->nullable()->after('description');
            $table->string('grade')->nullable()->after('benefits');
            $table->integer('session_count')->nullable()->default(4)->after('grade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
                $table->dropColumn(['benefits', 'grade', 'session_count']);
            });
    }
};
