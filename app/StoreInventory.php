<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

//use Store;
use App\LoadInventory;
use App\Product;
use App\InvoiceDetail;

class StoreInventory extends Model
{

    protected $fillable = ['store_id', 'product_id', 'qty'];


    public function store ()
    {
    	return $this->belongsTo(Store::class);
    }


    public function product ()
    {
    	return $this->belongsTo(Product::class);
    }


    public function delivery_detail ()
	{
		return $this->hasOne(DeliveryDetail::class);
	}

    public function load_inventory()
    {
        return hasOne(LoadInventory::class);
    }

    public static function saveDataFromInvoiceDetail(Request $request)
    {

        if($request->has('distribuir')) {
            foreach ($request->stores as $key => $value) {
                if(isset($value)){
                    $instance = self::firstOrNew(['store_id' => $key, 'product_id' => $request->product_id]);

                    if($instance->exists()){

                        $instance->qty = $instance->qty + $value;
                        $instance->save();
                        \App\LoadInventory::saveData($request, $value);
                        continue;

                    }

                    $instance->qty = $value;
                    $instance->save();
                    \App\LoadInventory::saveData($request, $instance, $value);
                }
            }

        } else {

            $store = \App\Store::where('default', 1)->firstOrFail();

            $instance = self::firstOrNew(['product_id' => $request->product_id, 'store_id' => $store->id]);

            if($instance->exists()){

                $instance->qty = $instance->qty + $request->qty;
                $instance->save();
                \App\LoadInventory::saveData($request, $instance, $request->qty);
                //\App\LoadInventory::saveData($request, $request->qty);
                return;

            }

            $instance->qty = $request->qty;
            $instance->save();
            \App\LoadInventory::saveData($request, $instance, $request->qty);
        }

    }

    public static function rollbackInventory($detail)
    {

        try {

            $detail->load_inventory->each(function($item, $key){
                $storeInventory = self::findOrFail($item->store_inventory_id);
                $storeInventory->qty = $storeInventory->qty - $item->qty;

                if($storeInventory->save())
                {
                    $item->forceDelete();
                }
            });

        } catch (Exception $e) {
            throw_if(true, \Exception::class, "Disculpe, hubo problemas al actualizar el inventario de la tienda.");
        }

    }
}
