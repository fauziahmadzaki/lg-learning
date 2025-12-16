<?php

namespace App\Models;

use App\Models\Tutor;
use App\Models\Branch;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
            'branch_id', 'name', 'grade', 'category',
            'price', 'duration', 'session_count', 
            'description', 'benefits', 'image'
        ];

    protected $casts =  [
        'benefits' => 'array'
    ];

    protected function badgeColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->category) {
                self::CAT_PRIVATE => 'purple',
                self::CAT_ROMBEL  => 'blue',
                default => 'gray',
            }
        );
    }

    public const CAT_PRIVATE = 'PRIVATE';
    public const CAT_ROMBEL = 'ROMBEL';

    public const GRADES = [
            'SD' => 'Sekolah Dasar (SD)',
            'SMP' => 'Sekolah Menengah Pertama (SMP)',
            'SMA' => 'Sekolah Menengah Atas (SMA)',
            'UTBK' => 'Persiapan UTBK / SNBT',
            'UMUM' => 'Bahasa Asing / Umum',
        ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function tutors()
    {
        return $this->belongsToMany(Tutor::class);
    }

    public function student()
    {
        return $this->belongsToMany(Student::class);
    }


    protected function pricePerSession(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Harga Total dibagi Jumlah Pertemuan
                return $this->session_count > 0 
                    ? $this->price / $this->session_count 
                    : 0;
            }
        );
    }

    // Panggil: $package->price_per_week
    // Asumsi: 'duration' disimpan dalam satuan HARI.
    protected function pricePerWeek(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Rumus: (Harga / Durasi Hari) * 7 Hari
                return $this->duration > 0 
                    ? ($this->price / $this->duration) * 7 
                    : 0;
            }
        );
    }

}
