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
            $table->decimal('savings_balance', 15, 2)->default(0)->after('status');
        });

        Schema::table('transactions', function (Blueprint $table) {
            // TUITION (Bimbel), SAVINGS_DEPOSIT (Tabungan Masuk), SAVINGS_WITHDRAWAL (Tabungan Keluar)
            $table->enum('type', ['TUITION', 'SAVINGS_DEPOSIT', 'SAVINGS_WITHDRAWAL'])->default('TUITION')->after('invoice_code');
            $table->string('description')->nullable()->after('payment_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('savings_balance');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['type', 'description']);
        });
    }
};
