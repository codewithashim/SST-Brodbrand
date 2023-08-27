<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBillModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'package_id',
        'months',
        'amount',
        'status',
        'paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
