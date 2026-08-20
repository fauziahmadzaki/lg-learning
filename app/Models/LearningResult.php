<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tutor_id',
        'session_date',
        'session_number',
        'topic',
        'attendance',
        'score',
        'notes',
        'homework',
    ];

    protected $casts = [
        'session_date' => 'date',
        'score'        => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Warna badge attendance untuk view.
     */
    public function getAttendanceBadgeAttribute(): string
    {
        return match($this->attendance) {
            'hadir' => 'green',
            'izin'  => 'yellow',
            'alfa'  => 'red',
            default => 'gray',
        };
    }

    /**
     * Warna score untuk view (merah < 70, kuning < 85, hijau >= 85).
     */
    public function getScoreColorAttribute(): string
    {
        if (is_null($this->score)) return 'gray';
        if ($this->score >= 85)   return 'green';
        if ($this->score >= 70)   return 'yellow';
        return 'red';
    }
}
