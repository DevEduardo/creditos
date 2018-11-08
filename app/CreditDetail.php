<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CreditDetail extends Model
{

	protected $dates = [
		'fee_date_expired', 
		'fee_date'
	];
    
    protected $fillable =
    [
    	'credit_id',
        'fee_number',
        'fee_amount',
        'fee_date',
    	'fee_date_expired',
        'payment',
        'base_amount',
        'is_per_pay',
        'is_payed',
        'is_expired',
        'days_expired',
        'interest_to_expired',
        'payment_method_id'
    ];


    public function credit ()
    {
    	return $this->belongsTo(Credit::class);
    }

    public function payment_method ()
    {
    	return $this->belongsTo(PaymentMethod::class);
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }

    public function getRealAmountAttribute()
    {
        $this->load('credit');

        return $this->is_expired ? ($this->fee_amount * (1 + (($this->credit->interest_expired/100) * $this->days_expired))) : $this->fee_amount;
    }

    public function getInterestAttribute()
    {
        $this->load('credit');

        return ($this->fee_amount *  (($this->credit->interest_expired/100) * $this->days_expired));
    }

    public static function createFees($credit_id)
    {
    	try {
			
			$credit 		= 	Credit::with('sale')->findOrfail($credit_id);
			$fee_amount = (($credit->debit) / ($credit->fees -1));
			
			
			if (!empty($credit)) {

				$credit_detail1 = [
					'credit_id'			=>		$credit->id,
					'fee_number'		=>		1,
					'fee_amount'		=>		$credit->payment,
					'fee_date'			=>		Carbon::now(),
					'fee_date_expired'	=>		Carbon::now()->addDay(3),
					'payment'			=>		$credit->payment,
					'is_per_pay'		=>		0,
					'is_payed'			=>		1,
					'is_expired'		=>		0,
					'days_expired'		=>		0,
					'created_at'		=>		Carbon::now(),
					'updated_at'		=>		null
				];

				CreditDetail::create($credit_detail1);

				
				
				for ($i=1; $i < $credit->fees; $i++) { 
					
					$credit_detail2 = [
						'credit_id'			=>		$credit->id,
						'fee_number'		=>		$i+1,
						'fee_amount'		=>		$fee_amount,
						'fee_date'			=>		Carbon::now()->addMonth($i),
						'fee_date_expired'	=>		Carbon::now()->addMonth($i)->addDay(3),
						'payment'			=>		0,
						'is_per_pay'		=>		0,
						'is_payed'			=>		0,
						'is_expired'		=>		0,
						'days_expired'		=>		0,
						'created_at'		=>		Carbon::now(),
						'updated_at'		=>		null
					];

					CreditDetail::create($credit_detail2);
				}

			}

		} catch (\Exception $e) {
			dd($e);
			throw_if(true, \Exception::class, "Error al registrar");
        }
    }


    public static function payFee ($request)
    {

    	try 
    	{
            
            $fee = CreditDetail::with('credit')->findOrFail($request['fee_id']);

            $payment = $request['payment'];
            $realPayment = $request['payment'];
            $payments = $request['payment'];
            $partial = 0;
            $porcent = 0;
            if ($payment < $fee->fee_amount) {
                $partial = 1;
            }

            if ($fee->is_expired) {
                $payment = $payment / (1 + (($fee->credit->interest_expired * $fee->days_expired)/100));    
                $realPayment = $payment;

                $porcent = round($payments) - round($payment);
            }

            $payment -= ($fee->real_amount - $payment);

            if ($payment <= 0) 
            {   $is_payed = 0;
                
                if (round($realPayment + $fee->payment) == $fee->fee_amount) {
                    $is_payed = 1;
                }
                $fee->update([
                    'payment' => (round($realPayment) + $fee->payment),
                    'is_payed' => $is_payed, 
                    'fee_date' => Carbon::now()->format('Y-m-d')
                ]);

                if ($payment == 0) {
                    Credit::updatePayment($fee);
                }
            } 
            else 
            {
                self::payNextFee($fee, $realPayment);
            }

            $payment = new Payment;

            $payment->amount = $request['payment'];
            $payment->type = 'credit_detail';
            $payment->way_to_pay = $request['way_to_pay'];
            $payment->concept = json_encode([
                'credit_detail_id' => $fee->id,
                'add_info' => 'Pago de cuotas'
            ]);

            $payment->user()->associate(Auth::user());
            $payment->save();

            $client = Sale::find($fee->credit->sale_id);

            $coupon = new CouponGet;
            $coupon->fee_id    = $request['fee_id'];
            $coupon->credit_id = $fee->credit->id;
            $coupon->amount    = $realPayment;
            $coupon->partial   = $partial;
            $coupon->type      = 4;
            $coupon->client_id = $client->client_id;
            $coupon->interests = $porcent; 
            $coupon->save();

        } 
        catch (Exception $e) 
        {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
    }

    protected static function payNextFee($fee, $payment) 
    {
    	$amount = 0;
    	$credit = $fee->credit;
    	$credit->load('credit_details');

    	$indicator = $payment - ($fee->real_amount - $fee->payment);

    	if ($indicator >= 0) 
    	{
    		$data = [
    			'payment' => $fee->real_amount,
    			'is_payed' => 1,
    		];
    	} 
    	else 
    	{
    		$data = [
    			'payment' => ($payment + $fee->payment),
    			'is_payed' => ($fee->real_amount == (string) ($payment + $fee->payment)),
    		];

    		#dd($data, ($fee->fee_amount == (string) ($payment + $fee->payment)));
    	}

    	$data['fee_date'] = Carbon::now()->format('Y-m-d');

    	$fee->update($data);

        if ($credit->credit_details->last()->id == $fee->id) {
        	Credit::updatePayment($fee);
        }

    	if ($indicator > 0 && $credit->credit_details->last()->id >= ($fee->id+1)) {
    		$fee = CreditDetail::with('credit')->findOrFail(($fee->id+1));

    		self::payNextFee($fee, $indicator);
		}
    }

    public function scopeGetCoupon($query, $id)
    {
        return $query->select('credit_details.fee_number', 'credit_details.is_payed','credit_details.is_expired', 'credit_details.days_expired', 'credit_details.payment', 'credit_details.id AS coupon', 'credit_details.fee_date', 'credit_details.fee_date_expired', 'credit_details.fee_amount', 
                              'credits.id AS creditID', 'credits.fees', 'credits.interest_expired', 'credits.created_at', 'sales.total', 'clients.id AS clientID', 'clients.dni', 'clients.name',
                              'profiles.district', 'profiles.between_street', 'profiles.address', 'profiles.postal_code' )
                     ->join('credits', 'credits.id', '=', 'credit_details.credit_id')
                     ->join('sales', 'sales.id', '=', 'credits.sale_id')
                     ->join('clients', 'clients.id', '=', 'sales.client_id')
                     ->join('profiles', 'profiles.id', '=', 'clients.profile_id')
                     ->where('credit_details.id', $id)
                     ->first();
    }

    public function scopeNextFee($query, $fee_number, $fee_id)
    {
        return $query->select('fee_number', 'fee_amount', 'fee_date_expired')
                     ->where('fee_number', $fee_number)
                     ->where('credit_details.id', $fee_id)
                     ->first();
    }
}
