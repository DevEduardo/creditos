<?php

namespace App\Exports;

use App\Client;
use App\Credit;
use App\CouponGet;
use App\CreditDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CouponExport implements FromView
{	

	protected $id;

	public function _consturct($id)
	{
		$this->id = $id;
	}

    public function view(): View
    {	
		$data   = CouponGet::where('fee_id', 381)->get();
		$data   = $data->last();
		$client = Client::find($data->client_id);
		$credit = Credit::find($data->credit_id);
		$fee    = CreditDetail::find( 381);
		if ($credit->fees == $fee->fee_number) {
		$nextFee = false;
		}else{
		$nextFee = CreditDetail::NextFee($fee->fee_number + 1,$fee->id +1);
		}
		
		return view('pdfs.coupon',[
                'data' => $data,
                'client' => $client,
                'credit' => $credit,
                'nextFee' => $nextFee,
                'fee' => $fee
            ]);
    }
}
