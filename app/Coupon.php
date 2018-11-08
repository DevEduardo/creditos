<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
    	'code',
    	'type',
    	'info',
    	'payment_id',
    	'credit_detail_id',
        'sale_id'
    ];

    public function payment()
    {
    	return $this->belongsTo(Payment::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }


    public function credit_detail()
    {
        return $this->belongsTo(CreditDetail::class);
    }

    public function credits()
    {
    	return $this->belongsToMany(Credit::class);
    }
}
