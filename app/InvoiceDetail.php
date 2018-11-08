<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;

use App\Invoice;
use App\InvoiceDetailTax;
use App\StoreInventory;
use App\Product;
use App\LoadInventory;

class InvoiceDetail extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'invoice_id', 'product_id', 'price', 'qty', 'subtotal',
        'discount1', 'discount2', 'discount3', 'discount4',
        'total_discount', 'total_taxes', 'pvp', 'benefit'
    ];

    
    public function invoice ()
    {
    	return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function invoice_detail_taxes ()
    {
    	return $this->hasMany(InvoiceDetailTax::class);
    }

    public function load_inventory()
    {
        return $this->hasMany(LoadInventory::class);
    }

    public static function saveData($request)
    {
        $invoiceDetail = new self();

        try {

            $invoice = Invoice::where('user_id', Auth::id())->where('finished', 0)->first();
            
        } catch (ModelNotFoundException $e) {
            
            throw_if(true, \Exception::class, "Factura no encontrada.");

        } catch (\ErrorException $e) {
            
            throw_if(true, \Exception::class, "La sesión de usuario expiró, inicie sesión y continue.");

        }

        $detail = null;
        $detail = self::where('invoice_id', $invoice->id)->where('product_id', $request->product_id)->first();

        if(isset($detail) && $detail->exists())
        {
            throw_if(true, \Exception::class, "Disculpe, este item ya se encuentra registrado, para editar debe eliminarlo.");
        }

        try {
            
            $invoiceDetail->fill($request->all());
            $invoiceDetail->invoice()->associate($invoice);
            $invoiceDetail->save();
            $request->invoice_detail_id = $invoiceDetail->id;

            /**
             * Se debe almacenar invoice_detail para obtener el id y poder crear 
             * 
             */
            $invoiceDetailTaxes = InvoiceDetailTax::saveData($request, $invoiceDetail->id);
            if($invoiceDetailTaxes->isNotEmpty())
            {
                $invoiceDetail->invoice_detail_taxes()->createMany($invoiceDetailTaxes->toArray());
            }

            StoreInventory::saveDataFromInvoiceDetail($request);
            Product::syncPrice($request);

            $invoice->invoice_details;
            $invoice->invoice_details->each(function($item, $key){
                $item->product;
            });

            $invoice->invoice_details->each(function($item, $key){
                $item->invoice_detail_taxes;
            });

        } catch (Exception $e) {
            throw_if(true, \Exception::class, "Registro no almacenado.");
        }

        return $invoice;
    }

}
