<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'properties' => 'array', // Supaya otomatis jadi JSON saat disimpan/diambil
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Relasi Polimorfik (Bisa nyambung ke Student, Transaction, dll)
    public function subject()
    {
        return $this->morphTo();
    }
}