<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini (opsional tapi best practice)

class Tutor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'address',
        'jobs',
        'phone',
        'image',
        'bio', // <--- WAJIB DITAMBAHKAN
        
    ];

    /**
     * Casting otomatis tipe data database ke tipe data PHP
     */
    protected $casts = [
        'jobs' => 'array', // <--- SANGAT PENTING: Ubah JSON DB jadi Array PHP
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }
}