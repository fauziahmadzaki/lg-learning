<?php

namespace App\Models;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function tutors()
    {
        return $this->hasMany(Tutor::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function packages()
    {
        return $this->hasMany(\App\Models\Package::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) {
            if (empty($branch->slug)) {
                $branch->slug = \Illuminate\Support\Str::slug($branch->name);
            }
        });

        static::updating(function ($branch) {
             // Opsional: Update slug jika nama berubah?
             // Biasanya URL dimaintain agar tidak broken link, tapi jika user minta "slug dari nama",
             // mungkin sebaiknya diupdate jika nama berubah.
             if ($branch->isDirty('name') && empty($branch->slug)) {
                 $branch->slug = \Illuminate\Support\Str::slug($branch->name);
             } elseif ($branch->isDirty('name')) {
                 $branch->slug = \Illuminate\Support\Str::slug($branch->name);
             }
        });
    }
}
