<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'transaction_id', // Nullable (Terisi hanya jika user sudah checkout)
        'title',          // Contoh: "SPP Minggu 1"
        'amount',         // Contoh: 50000
        'due_date',       // Tanggal jatuh tempo
        'status',         // UNPAID, PENDING, PAID
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount'   => 'decimal:0',
    ];

    // Relasi: Tagihan milik siapa?
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi: Tagihan ini dibayar pakai transaksi nomor berapa?
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}