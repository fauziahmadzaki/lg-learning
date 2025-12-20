<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'branch_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }
    public function isCentralAdmin()
    {
        // Must have NO branch AND be an 'admin'
        // If role column is nullable and legacy admins have null, we might need flexibility.
        // But for security, strict check is better. Assuming DB Seeder sets 'admin'.
        return is_null($this->branch_id) && $this->role === 'admin';
    }

    public function getRoleLabelAttribute()
    {
        if ($this->isCentralAdmin()) {
            return 'Admin Pusat';
        }

        // Jika punya branch_id, cek apakah field 'role' ada isinya
        // Jika tidak, default 'Kepala Cabang' atau 'Staff Cabang'
        return match($this->role) {
            'admin' => 'Admin Cabang', // Admin with Branch
            'tutor' => 'Tutor',
            'owner' => 'Pemilik',
            default => 'Staff Cabang', // Default fallback
        };
    }

    public function getDashboardUrlAttribute()
    {
        // 1. Central Admin
        if ($this->isCentralAdmin()) {
            return route('admin.dashboard');
        }

        // 2. Branch User (Must have Branch ID)
        if ($this->branch_id) {
            // Lazy load branch if not loaded, to get the slug
            if (!$this->relationLoaded('branch')) {
                $this->load('branch');
            }
            // Passing the model instance lets Laravel use getRouteKeyName() (slug)
            return route('branch.dashboard', $this->branch);
        }

        // 3. Fallback (Tutors without Branch, Students, etc.)
        // Redirect to Home or maybe a generic Profile page?
        // User complained about being redirected to Admin Dashboard. 
        // Returning url('/') is safe.
        return route('home'); 
    }
}
