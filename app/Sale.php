<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at', 'date'];

	protected $fillable = [
		'number',
		'type', 
		'date', 
		'company_id', 
		'client_id', 
		'user_id', 
		'tax', 
		'discount', 
		'total', 
		'observations',
		'finished'
	];

	public function getStringTypeAttribute()
	{	
		$string = '';

		switch ($this->type) {
			case 'sing':
				$string = 'Seña';
				break;

			case 'simple':
				$string = 'Venta directa';
				break;

			case 'online':
				$string = 'Venta online';
				break;

			case 'others':
				$string = 'Venta otras cuentas';
				break;
			
			default:
				$string = 'Crédito';
				break;
		}

		return $string;
	}
	
	public function company ()
	{
		return $this->belongsTo(Company::class);
	}


	public function client ()
	{
		return $this->belongsTo(Client::class);
	}


	public function sale_details ()
	{
		return $this->hasMany(SaleDetail::class);
	}


	public function payment_types ()
	{
		return $this->hasMany(PaymentType::class);
	}

	public function user ()
	{
		return $this->belongsTo(User::class);
	}

	public function credit ()
	{
		return $this->hasOne(Credit::class);
	}

	public function authorization()
	{
		return $this->hasOne(Authorization::class);
	}

	public function coupon()
	{
		return $this->hasOne(Coupon::class);
	}
}
