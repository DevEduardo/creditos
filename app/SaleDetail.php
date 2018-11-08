<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Sale;
use App\Inventory;
use App\Tax;


class SaleDetail extends Model
{

    protected $fillable = ['product_id', 'price', 'qty', 'subtotal', 'discount', 'amount_discount', 'taxes'];

    public function sale ()
    {
    	return $this->belongsTo(Sale::class);
    }

    public function product ()
    {
    	return $this->belongsTo(Product::class);
    }

    public static function saveData(\Illuminate\Http\Request $request)
    {
      $detail = new self();
      $user_id = null;

      try {
          $user_id = Auth::id();
      } catch (Exception $e) {
          throw_if(true, \Exception::class, "Su sesión ha expirado.");
      }

      try {

          $sale = Sale::where('id', $request->sale_id)->where('finished', 0)->where('user_id', $user_id)->firstOrFail();

      } catch (Exception $e) {

          throw_if(true, \Exception::class, "Venta no encontrada.");

      }

      try {

          $inventory = Inventory::where('product_id', $request->product_id)->firstOrFail();
          if($inventory->qty < $request->qty)
          {
              throw new \Exception("El producto que intenta agregar no tiene stock.", 404);
          }

      } catch (ModelNotFoundException $e) {
          throw_if(true, ModelNotFoundException::class, "El producto que intenta agregar no tiene stock.");
      }

      try {

        $detail->fill($request->all());

        $detail->subtotal = ceil($request->qty * $request->price);

        /*if(isset($request->tax))
        {

          $tax = explode(",", $request->tax);
          $taxes = $taxes = Tax::whereIn('id', $tax)->pluck('value', 'id');

          foreach ($taxes as $key => $item) {

              $detail->taxes = $detail->taxes.$item;

              if(count($taxes) - 1 === $key)
              {
                  $detail->taxes = $detail->taxes.",";
              }

              $detail->amount_taxes += ($detail->subtotal * ($item / 100));
          }

        }*/

        if($request->has('discount'))
        {
          $discount = $request->discount > 0.00 ? $request->discount : 0.00;
          $detail->discount = $discount;
          $detail->amount_discount = ceil(($detail->discount / 100) * $detail->subtotal);
          $detail->subtotal -=  $detail->amount_discount;
        }

        $detail->sale_id = $sale->id;

        $detail->save();

        $inventory->decrementQty($request->product_id, $request->qty);

        $detail->product;

      } catch (Exception $e) {
          throw_if(true, \Exception::class, "Detalle no almacenado.");
      } catch (ModelNotFoundException $e) {
          throw_if(true, ModelNotFoundException::class, "El producto que intenta agregar no tiene stock.");
      }

      return $detail;
    }

    public function scopeGetClient($query, $client)
    {
      return $query->select('credits.id AS creditID', 'credits.status', 'credits.is_payed', 'sales.id', 'sales.date', 'sales.total', 'products.name AS product', 'sales.finished', 'sales.type')
                             ->join('products','products.id','=','sale_details.product_id')
                             ->join('sales','sales.id','=','sale_details.sale_id')
                             ->leftJoin('credits','credits.sale_id','=','sales.id')
                             ->join('clients','clients.id','=','sales.client_id')
                             ->whereNotIn('sales.type', ['online', 'simple', 'others', 'sing'])
                             ->where('sales.client_id', $client)
                             ->where('sales.deleted_at', NULL)
                             ->get();
    }
}
