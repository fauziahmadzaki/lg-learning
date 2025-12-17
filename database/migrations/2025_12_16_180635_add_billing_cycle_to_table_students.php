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
            //
            $table->enum('billing_cycle', ['full', 'monthly', 'weekly'])->default('monthly')->after('status');
            $table->date('next_billing_date')->nullable()->after('billing_cycle');
            $table->string('access_token', 64)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            Schema::table('students', function (Blueprint $table) {
             $table->dropColumn(['billing_cycle', 'next_bill_date', 'access_token']);
            });
        });
    }
};
