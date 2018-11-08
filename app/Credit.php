<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at', 'date_advance_I', 'date_advance_II'];

	protected $fillable = [
		'sale_id',
		'amount',
		'final_amount',
		'advance_I',
		'date_advance_I',
		'advance_II',
		'date_advance_II',
		'type',
		'scooter',
		'fees',
		'interest',
		'interest_expired',
		'is_payed',
		'way_to_pay',
		'observation',
		'status',
		'add_info',
		'discharge_at'
	];

	public function getPaymentAttribute()
	{
		$payment = 0;

		$this->load(['credit_details' => function ($query){
			$query->where('is_payed', 1);
		}]);

		$this->credit_details->each(function ($detail) use (&$payment){
			$payment += $detail->fee_amount+($detail->fee_amount*($detail->interest_expired/100));
		});

		return '('.$this->credit_details->count().') '.number_format($payment, 0, ',', '.');
	}

	public function getPaymentRawAttribute()
	{
		$payment = 0;

		$this->load(['credit_details' => function ($query){
			$query->where('is_payed', 1);
		}]);

		$this->credit_details->each(function ($detail) use (&$payment){
			$payment += $detail->fee_amount+($detail->fee_amount*($detail->interest_expired/100));
		});

		return $payment;
	}

	public function getFeeAmountAttribute()
	{	
		if ($this->type != 'sing') {
			$fee_amount = $this->final_amount/$this->fees;

			return number_format($fee_amount, 0, ',', '.');
		} else {
			return 'N/A';
		}
		
	}

	public function getFinancialAmountAttribute()
	{
		if ($this->type == 'sing') {
			return 0;
		} else {
			return $this->amount;
		}
	}

	public function getStringTypeAttribute()
	{	
		$string = '';

		switch ($this->type) {
			case 'sing':
				$string = 'Seña';
				break;

			case 'two_advance':
				$string = 'Doble avance';
				break;
			case 'scoter':
				$string = 'Moto';
				break;
			
			default:
				$string = 'Crédito';
				break;
		}

		return $string;
	}

	public function getStringWayToPayAttribute()
	{	
		$string = '';

		switch ($this->way_to_pay) {
			case 'cash':
				$string = 'Efectivo';
				break;

			case 'card':
				$string = 'Tarjeta';
				break;
			
			default:
				$string = 'Tarjeta y Efectivo';
				break;
		}

		return $string;
	}

	public function scopeCreditUser($query, $date, $dateEnd)
    {
          return $query->select('credits.*', 'users.name')
                     ->join('sales', 'sales.id', '=', 'credits.sale_id')
                     ->join('users', 'users.id', '=', 'sales.user_id')
                     ->where('credits.status', 'unsubscribe')
                     ->whereDate('credits.created_at', '>=', $date)
                     ->whereDate('credits.created_at', '<=', $dateEnd)
                     ->get();
    }

	public function coupons()
	{
		return $this->belongsToMany(Coupon::class);
	}

	public function sale ()
	{
		return $this->belongsTo(Sale::class);
	}


	public function credit_details ()
	{
		return $this->hasMany(CreditDetail::class);
	}


	public static function saveData ($data)
	{
		try {
			
			$credit = new self();

			$credit->fill($data);
			$credit->is_payed = 0;
			$credit->payment = $data['advance'];
			$credit->debit 	= $data['amount'] - $data['advance'];
			$credit->save();

			CreditDetail::createFees($credit->id);	
		
		} catch (\Exception $e) {
			throw_if(true, \Exception::class, "Error al registrar crédito");
        }

        return $credit;
	}


	public static function updatePayment ($fee)
	{
		try {

			$credit = Credit::findOrFail($fee->credit_id);

			$credit->load('credit_details');

			if ($credit->credit_details->last()->id == $fee->id) {
				$credit->update(['is_payed' => 1]);
			}

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
	}

	

}
