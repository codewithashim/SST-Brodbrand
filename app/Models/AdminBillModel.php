<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBillModel extends Model
{
    use HasFactory;
    protected $table = 'admin_bills';
    protected $fillable = [
        'user_id',
        'package_id',
        'months',
        'amounts',
        'status',
        'paid',
        'due_date'
    ];

    public function customer()
    {
        return $this->hasOne(CustomerModel::class, 'id', 'cust_id');
    }
}
