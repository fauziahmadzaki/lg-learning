<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'branch_id',
        'package_id',
        'day_of_week',
        'start_time',
        'end_time',
        'quota'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
