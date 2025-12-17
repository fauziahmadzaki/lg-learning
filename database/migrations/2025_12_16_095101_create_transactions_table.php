<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Kode Invoice Xendit (Contoh: INV-BATCH-2023...)
            $table->string('invoice_code')->unique();
            
            // Relasi ke Siswa
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            
            // HAPUS kolom package_id dan package_name_snapshot.
            // Alasannya: Transaksi ini bersifat "Global/Induk".
            // Rincian apa yang dibayar (paket apa, minggu ke berapa) akan ada di tabel 'bills'.
            
            // Total yang harus dibayar ke Xendit (Gabungan dari beberapa bills)
            $table->decimal('total_amount', 12, 0);
            
            // Status Pembayaran Xendit
            $table->enum('status', ['PENDING', 'PAID', 'EXPIRED', 'FAILED', 'CANCELLED'])->default('PENDING');
            
            // Link Pembayaran
            $table->text('payment_url')->nullable();
            
            // Data Balikan dari Xendit (metode bayar, channel, waktu lunas)
            $table->string('payment_method')->nullable();
            $table->string('payment_channel')->nullable();
            $table->dateTime('paid_at')->nullable();
            
            // Waktu user klik tombol "Checkout/Bayar"
            $table->dateTime('transaction_date')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};