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
    Schema::create('bills', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        
        // HUBUNGAN KE TRANSAKSI
        // Awalnya NULL (UNPAID). Saat user checkout, baru diisi ID Transaksi-nya.
        $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
        
        // Detail Tagihan (Disinilah info paket disimpan)
        // Contoh: "SPP Mingguan - Paket Jarimatika (Minggu 2 Jan)"
        $table->string('title'); 
        $table->decimal('amount', 12, 0);
        
        // Kapan dibuat robot & kapan jatuh tempo
        $table->date('due_date');
        
        // Status: UNPAID (Baru), PENDING (Proses Bayar), PAID (Lunas)
        $table->enum('status', ['UNPAID', 'PENDING', 'PAID'])->default('UNPAID');
        
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('bills');
}
};
