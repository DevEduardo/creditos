<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Invoice extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at', 'date'];

	protected $fillable = [
		'code', 
		'company_id', 
		'provider_id', 
		'subtotal', 
		'total', 
		'observations'
	];


	public function company ()
	{
		return $this->belongsTo(Company::class);
	}

	public function provider ()
	{
		return $this->belongsTo(Provider::class);
	}

	public function invoice_details ()
	{
		return $this->hasMany(InvoiceDetail::class);
	}

	public static function openInvoice($request)
	{
		
		$invoice = new self();

		$date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

		try {
			
			$invoice->fill($request->all());
			$invoice->date = $date;

			$invoice->user_id = Auth::id();
			$invoice->company_id = Auth::User()->company_id;

			$invoice->save();
		} catch (Exception $e) {
			
			throw_if(true, \Exception::class, "Factura no aperturada, intente nuevamente.");

		} catch (\ErrorException $e) {
			throw_if(true, \Exception::class, "La sesión de usuario expiró, inicie sesión y continue.");	
		}

		return $invoice;
	}
}
