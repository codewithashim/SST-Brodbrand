<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'package_id', 'name', 'email', 'phone', 'nid', 'pon_mac', 'route_mac', 'address', 'status', 'bill_amount', 'months','packeg_amount', 'payment_status', 'last_payment_date'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
