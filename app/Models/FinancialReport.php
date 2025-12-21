<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'package_id',
        'month',         // Format: Y-m-d (tanggal 1 bulan tsb)
        'total_income',
        'total_expense',
        'net_profit',
        'transaction_count'
    ];

    protected $casts = [
        'month' => 'date',
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
