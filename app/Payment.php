<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    	'amount',
    	'type',
    	'way_to_pay',
    	'concept',
    	'user_id'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }

    public function getWayToPayStringAttribute()
    {
        $way = '';

        switch ($this->way_to_pay) {
            case 'cash':
                $way = 'Efectivo';
                break;
            case 'online':
                $way = 'Venta online';
                break;
            case 'others':
                $way = 'Venta otras cuentas';
                break;
            default:
                $way = 'Tarjeta';
                break;
        }

        return $way;
    }
}
