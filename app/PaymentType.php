<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $fillable = ['sale_id', 'cash', 'credit', 'financial', 'credit', 'gift'];

    
    public function sale ()
    {
    	return $this->belongsTo(Sale::class);
    }

}