<?php
namespace App\Observers;

use App\Sale;
use App\Coupon;
use App\Credit;
use App\Payment;
use App\CreditDetail;

/**
 * Calse que observa el modelo payment
 */
class PaymentObserver 
{
	
	/**
     * Listen to the Payment created event.
     *
     * @param  \App\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
     	$concept = json_decode($payment->concept, true);

     	foreach ($concept as $key => $value) {
            if ($key == 'add_info') {
                continue;
            }

     		switch ($key) {
     			case 'sale_id':
     				$sale = Sale::find($value);
     				$this->createCoupon($payment, 'simple', $sale);
     				break;

     			case 'credit_id':
     				$credit = Credit::find($value);
     				($credit->type == 'sing') ? $this->createCoupon($payment, 'sing', $credit) : $this->createCoupon($payment, 'credit', $credit);
     				break;
     			
     			default:
     				$cDetail = CreditDetail::with('credit')->find($value);
     				($cDetail->credit->type == 'sing') ? $this->createCoupon($payment, 'sing', $cDetail) : $this->createCoupon($payment, 'credit_detail', $cDetail);
     				break;
     		}
     	}
    }

    private function createCoupon(Payment $payment, $type, $model)
    {
    	$coupon = new Coupon;

    	$coupon->code = uniqid();
    	$coupon->type = $type;

    	$coupon->payment()->associate($payment);

    	if ($type == 'simple') {
    		$coupon->info = json_encode(['id' => $model->id, 'model' => 'Sale']);
    		$coupon->sale()->associate($model);
            $coupon->save();
    	} else {
    		$concept = json_decode($payment->concept, true);

    		if ($concept['add_info'] == 'avance del credito' || $concept['add_info'] == 'Pago de segundo avance') {
    			$coupon->info = json_encode(['id' => $model->id, 'model' => 'Credit']);
                $coupon->save();

    			$coupon->credits()->attach($model);
    		} else {
    			$coupon->info = json_encode(['id' => $model->id, 'model' => 'CreditDetail']);
                $coupon->save();

    			$coupon->credit_detail()->associate($model);
    		}
    	}
    }
}