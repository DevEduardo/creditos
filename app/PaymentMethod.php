<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name'];


    public function credit_details ()
    {
    	return $this->hasMany(CreditDetail::class);
    }
}
