<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Low extends Model
{
    protected $fillable = [
    	'type',
    	'user',
    	'amount',
    	'observation',
    	'client_id'
    ];

    public function scopeLowCoupon($query, $date_start, $date_end, $type)
    {
    	return $query->where('type', $type)
    				 ->whereDate('created_at', '>=', $date_start)
                     ->whereDate('created_at', '<=', $date_end)
                     ->get();
    }

    public function scopeRefund($query, $date_start, $date_end)
    {
        return $query->whereDate('created_at', '>=', $date_start)
                     ->whereDate('created_at', '<=', $date_end)
                     ->sum('amount');
    }
}
