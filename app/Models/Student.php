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
        // 'package_id', <--- HAPUS INI karena sudah pakai tabel pivot
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    // Relasi MANY-TO-MANY (Siswa bisa punya banyak paket)
    public function packages()
    {
        // Parameter ke-2 adalah nama tabel pivot Anda
        return $this->belongsToMany(Package::class, 'student_packages');
    }
    
    // ... helper status color ...
}