<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'type',             // TUITION, SAVINGS_DEPOSIT, SAVINGS_WITHDRAWAL
        'description',      // Catatan manual
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

    public function package()
    {
        return $this->belongsTo(Package::class);
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

    // --- SCOPES ---
    public function scopeTuition($query)
    {
        return $query->where('type', 'TUITION')
                     ->orWhereNull('type'); // Backward compatibility
    }

    public function scopeSavings($query)
    {
        return $query->whereIn('type', ['SAVINGS_DEPOSIT', 'SAVINGS_WITHDRAWAL']);
    }
}