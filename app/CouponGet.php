<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponGet extends Model
{
    protected $table = 'couponsGet';

    protected $fillable = [
    	'fee_id',
    	'credit_id',
    	'client_id',
    	'amount',
    	'partial',
    	'interests',
    	'type'
    ];
}
