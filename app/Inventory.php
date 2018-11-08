<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Inventory extends Model
{

    protected $fillable = ['reference', 'stock', 'op', 'qty', 'product_id', 'company_id', 'user_id'];


    public function product ()
    {
    	return $this->belongsTo(Product::class);
    }


    public function company ()
    {
    	return $this->belongsTo(Company::class);
    }

    public function user ()
    {
      return $this->belongsTo(User::class);
    }

    public function incrementQty($product_id, $qty)
    {
        try {

            $inventory = self::where('product_id', $product_id)->firstOrFail();
            $inventory->qty += $qty;
            $inventory->save();

        } catch (Exception $e) {
            throw_if(true, \Exception::class, "Disculpe!, el inventario no pudo ser actualizado.");
        }

    }

    public function decrementQty($product_id, $qty)
    {
      try {

          $inventory = self::where('product_id', $product_id)->firstOrFail();
          $inventory->qty -= $qty;
          $inventory->save();

      } catch (Exception $e) {
          throw_if(true, \Exception::class, "Disculpe!, el inventario no pudo ser actualizado.");
      }
    }
}
