<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',     // Kode Xendit (INV-BATCH-...)
        'student_id',
        'total_amount',     // Ganti 'amount' jadi 'total_amount' sesuai migrasi
        'status',           // PENDING, PAID, EXPIRED, FAILED
        'payment_url',      // Link Xendit
        'payment_method',   // BCA, OVO, dll
        'payment_channel',
        'paid_at',
        'transaction_date', // Waktu user klik bayar
    ];

    protected $casts = [
        'total_amount'     => 'decimal:0',
        'paid_at'          => 'datetime',
        'transaction_date' => 'datetime',
    ];

    // Relasi: Transaksi milik siapa?
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi: Transaksi ini membayar tagihan apa saja? (PENTING)
    // Satu transaksi bisa melunasi banyak Bill
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
    
    // Helper Warna Badge Status (Opsional, untuk View)
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'PAID'      => 'green',
            'PENDING'   => 'yellow',
            'EXPIRED'   => 'gray',
            'FAILED'    => 'red',
            default     => 'gray'
        };
    }
}