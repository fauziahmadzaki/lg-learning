<?php

namespace App\Models;

use App\Models\Tutor;
use App\Models\Branch;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    // DEPRECATED: GRADES constant removed in favor of PackageCategory model.
    // protected $grade = ... (removed)

    protected $fillable = [
            'branch_id', 'package_category_id', 'name', 'grade', 'category',
            'price', 'duration', 'session_count', 
            'description', 'benefits', 'image', 'slug'
        ];

    protected $casts = [
        'benefits' => 'array',
    ];

    // ...

    public function packageCategory()
    {
        return $this->belongsTo(PackageCategory::class, 'package_category_id');
    }

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



    protected function badgeColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->category) {
                    'PRIVATE' => 'indigo',
                    'ROMBEL' => 'pink',
                    default => 'gray',
                };
            }
        );
    }
}
