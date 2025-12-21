<?php

namespace App\Models;

use App\Models\Branch;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, LogsActivity;

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
        'branch_id',
        'package_id'
    ];

    protected $casts = [
        'join_date'      => 'date',
        'next_billing_date' => 'date', // Fix Typo: next_bill_date -> next_billing_date
    ];

    // Relasi Paket (Belongs To) - Siswa cuma punya 1 paket
    public function package()
    {
        return $this->belongsTo(Package::class);
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
    
    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function getPortalLinkAttribute()
    {
        return url('/portal/' . $this->access_token);
    }
}