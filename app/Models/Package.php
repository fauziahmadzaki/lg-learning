<?php

namespace App\Models;

use App\Models\Tutor;
use App\Models\Branch;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
            'branch_id', 'name', 'grade', 'category',
            'price', 'duration', 'session_count', 
            'description', 'benefits', 'image'
        ];

    protected $casts =  [
        'benefits' => 'array'
    ];

    // --- ACCESSORS ---

    public function getDurationStringAttribute()
    {
        // Asumsi duration dalam Hari
        $days = $this->duration;

        if ($days % 30 == 0) {
            return ($days / 30) . ' Bulan';
        }
        
        return $days . ' Hari';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
            return \Illuminate\Support\Facades\Storage::url($this->image);
        }
        
        // Return Placeholder based on Category
        return match($this->category) {
            'UTBK'   => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&q=80&w=800',
            'SMA'    => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800',
            'SMP'    => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=800',
            'SD'     => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=800',
            'UMUM'   => 'https://images.unsplash.com/photo-1513258496098-b05360482272?auto=format&fit=crop&q=80&w=800',
            default  => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800',
        };
    }


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

    public function students()
    {
        return $this->hasMany(Student::class);
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
