<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Tax;


class InvoiceDetailTax extends Model
{
    protected $fillable = ['invoice_detail_id', 'tax_id', 'tax_value', 'value'];


    public function invoice_detail()
    {
    	return $this->belongsTo(InvoiceDetail::class);
    }

    public function tax ()
    {
    	return $this->belongsTo(Tax::class);
    }


    public static function saveData($request, $invoiceDetailId)
    {
    	$invoice_detail_taxes = collect([]);

    	try {
    		if($request->has('taxes'))
    		{
    			$taxes = Tax::whereIn('id', array_flatten($request->get('taxes')))->get();

	    		$taxes->each(function($tax, $key) use (&$invoice_detail_taxes, $request, $invoiceDetailId){
	    			
	    			$detail = new self();
	    			
	    			$detail->tax_id = $tax->id;
	    			$detail->tax_value = $tax->value;

                    $importe = ($request->subtotal - $request->total_discount);

	    			$detail->value = ($importe * ($tax->value / 100));
	    			$detail->invoice_detail_id = $invoiceDetailId;

	    			$invoice_detail_taxes->push($detail);
	    		});
    		}

    	} catch (Exception $e) {
    		throw_if(true, \Exception::class, "Registro no almacenado.");
    	}

    	return $invoice_detail_taxes;
    }
}