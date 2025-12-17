<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_phone',
        'school',
        'grade',
        'status',
        'join_date',
        'email',
        // --- FIELD BARU UNTUK BILLING & PORTAL ---
        'billing_cycle',  // weekly, monthly, full
        'next_billing_date', // Kapan robot harus nagih
        'access_token',   // Token rahasia link portal
    ];

    protected $casts = [
        'join_date'      => 'date',
        'next_bill_date' => 'date', // Pastikan dicasting ke Date (Carbon)
    ];

    // Relasi Paket (Pivot)
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'student_packages');
    }

    // Relasi: Siswa punya banyak Tagihan (Bills)
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    // Relasi: Siswa punya banyak Riwayat Transaksi (Transactions)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    // Helper untuk Link Portal (Opsional)
    // Cara pakai di blade: {{ $student->portal_link }}
    public function getPortalLinkAttribute()
    {
        return url('/portal/' . $this->access_token);
    }
}