<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

use StoreInventory;

class LoadInventory extends Model
{
	use SoftDeletes;

    public function invoice_detail()
    {
    	return $this->belongsTo(InvoiceDetail::class);
    }

    public function store_inventory()
    {
    	return $this->belongsTo(StoreInventory::class);
    }

    public static function saveData(Request $request, $store, $qty)
    {
    	try {
    		
    		$load = new self();
    		$load->invoice_detail_id = $request->invoice_detail_id;
    		$load->store_inventory_id = $store->id;
    		$load->qty = $qty;
    		$load->save();

    	} catch (Exception $e) {
    		
    		throw_if(true, \Exception::class, "Disculpe, hubo un error mientras se distribuian los items en los almacenes");

    	}

    	return $load;
    }

    public static function syncWithInventory($product_id, $qty)
    {
    	try {
    		
    		$product = \App\Product::findOrFail($product_id);

    		if($product->update_price)
    		{
    			$product->last_price = $product->price;
    			$product->price = $product->next_price;
    			$product->next_price = 0.00;
    			$product->update_price = 0;
    			$product->save();
    		}

			$inventory = \App\Inventory::firstOrNew(['product_id' => $product_id]);
			$inventory->qty = $inventory->qty + $qty;
			$inventory->stock = $product->stock_minimun;
			$inventory->company_id = 1;

			$inventory->save();



    	} catch (Exception $e) {
    		
    		throw_if(true, \Exception::class, "Disculpe, hubo un error al sincronizar los items de la factura con el inventario");

    	}
    }
}
