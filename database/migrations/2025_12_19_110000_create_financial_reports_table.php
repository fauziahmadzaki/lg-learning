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
        Schema::dropIfExists('financial_reports');
        
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained()->onDelete('set null');
            $table->date('month'); // Disimpan sebagai tanggal 1 bulan tersebut
            
            $table->decimal('total_income', 15, 2)->default(0);
            $table->decimal('total_expense', 15, 2)->default(0); // Buat future use (Operational Cost)
            $table->decimal('net_profit', 15, 2)->default(0);
            
            $table->integer('transaction_count')->default(0);
            
            $table->timestamps();

            // Index biar cepat filter per bulan/cabang
            $table->index(['month', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
