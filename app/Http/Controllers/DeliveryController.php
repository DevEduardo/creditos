<?php

namespace App\Http\Controllers;

use App\Product;
use App\Delivery;
use App\SaleDetail;
use App\DeliveryDetail;
use App\StoreInventory;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class DeliveryController extends Controller
{
    function __construct()
    {
        Carbon::setLocale('es');
    }

    /**
     * Este metodo devuelve una lista de todos los depachos en el sistema
     *
     */
    public function index()
    {
        $title = 'Listado de despachos';

        $deliveries = Delivery::orderBy('created_at', 'DESC')->get();

        $getProduct = SaleDetail::orderBy('created_at', 'DESC')->get();
        $products = Product::all();
        
        return view('deliveries.index')->with(compact('deliveries', 'title', 'products','getProduct'));
    }

    /**
     * Este metodo devuelve la vista con los almacenes y la cantidad disponible del producto
     *
     */
    public function dispatches(Delivery $delivery)
    {
        $title = 'Distribución del producto';

        $delivery->load('sale.sale_details.product.store_inventories.store');

        return view('deliveries.dispatches')->with(compact('delivery', 'title'));
    }

    /**
     * Este metodo se encarga del despacho
     * 
     */
    public function send(Delivery $delivery, Request $request)
    {
        $delivery->load('sale.sale_details.product.store_inventories.store', 'delivery_details');

        //array en el que guardaremos los datos para poder llenar el delivery_details
        $data = [];

        //Recorro los detalles de la venta
        foreach ($delivery->sale->sale_details as $detail) 
        {
            //variable que usaremos para validación
            $quantity = 0;

            //Recorro los inventarios
            foreach ($detail->product->store_inventories as $inventory) 
            {
                //armo el nombre del input
                $nameInput = 'inventory'.$inventory->id.'-'.$inventory->product_id;

                //verifico que no sea un valor nulo
                if (! empty($request->get($nameInput))) 
                {
                    //verifico que la cantidad que se intenta despachar del inventario coincida con la disponible en el mismo
                    if ($inventory->qty < $request->get($nameInput)) 
                    {
                        alert()->flash('Advertencia', 'warning', ['text' => 'La cantidad que intenta despachar no esta disponible en el inventario: '.$inventory->store->name.'.']);
                        return redirect()->back()->withInput();
                    }

                    //acumulo las cantidades despachadas del producto
                    $quantity += $request->get($nameInput);

                    $data[] = [
                        'inventory_id' => $inventory->id,
                        'qty' => $request->get($nameInput),
                        'product_id' => $inventory->product_id
                    ];
                }
            }

            //Si ya tengo detalles anexo la cantidad que ya despache
            if (! empty($delivery->delivery_details)) 
            {
                $delivery->delivery_details->each(function ($ddetail) use (&$quantity, $detail) {
                    if ($ddetail->product_id == $detail->product_id) {
                        $quantity += $ddetail->qty;
                    }
                });
            }

            //Valido que la cantidad despachada coincida con la que se vendio del producto
            if ($detail->qty < $quantity)  
            {
                alert()->flash('Advertencia', 'warning', ['text' => 'la cantidad que intenta despachar del producto no coincide con la vendida.']);
                return redirect()->back()->withInput();
            }
        }

        //Inicio la transaccion padre
        //DB::beginTransaction();

        //recorro el array de datos
        foreach ($data as $key => $value) 
        {
            $deliveryDetail = new DeliveryDetail;
            $inventory = StoreInventory::findOrFail($value['inventory_id']);
            $product = Product::findOrFail($value['product_id']);

            //resto la cantidad que se esta despachando
            $inventory->qty -= $value['qty'];

            $deliveryDetail->qty = $value['qty'];
            $deliveryDetail->store_inventory()->associate($inventory);
            $deliveryDetail->delivery()->associate($delivery);
            $deliveryDetail->product()->associate($product);

            //Inicio una transaccion para el query del store_inventories
            //DB::beginTransaction();
            try 
            {    
                $inventory->save();
            } 
            catch (QueryException $e) 
            {
                //DB::rollback();
                alert()->flash($e->getMessage(), 'warning', ['text' => 'Error al restar la cantidad del inventario.']);
                return redirect()->back()->withInput();
            }

            //DB::commit();

            //Inicio una transaccion para el query del delivery_details
            //DB::beginTransaction();
            try 
            {
                $deliveryDetail->save();    
            } 
            catch (QueryException $e) 
            {
                //DB::rollback();
                alert()->flash($e->getMessage(), 'warning', ['text' => 'Error al generar los detalles del despacho.']);
                return redirect()->back()->withInput();                
            }

            //DB::commit();
        }

        $delivery->load('delivery_details');
        
        $qtySale = 0;
        $qtyDeli = 0;

        if (! empty($delivery->delivery_details)) 
        {
            foreach ($delivery->delivery_details as $ddetail) {
                $qtyDeli = ($qtyDeli + $ddetail->qty);
            }
            /*$delivery->delivery_details->each(function ($ddetail) use (&$qtyDeli) {
            });*/
        }


        $delivery->sale->sale_details->each(function ($sdetail) use (&$qtySale) {
            $qtySale = ($qtySale + $sdetail->qty);
        });

        if ($qtyDeli == $qtySale) {
            $delivery->completed = true;
        }

        try 
        {
            $delivery->save();    
        } 
        catch (QueryException $e) 
        {
            //Devuelvo los cambios realizados, en caso de error
            //DB::rollback();

            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error al completar el depacho.']);
            return redirect()->back()->withInput();
        }
        //Hago commit si todo va bien
        //DB::commit();

        alert()->flash('Completado', 'success', ['text' => 'Se ha realizado el despacho con exito.']);
        return redirect()->route('deliveries.index');
    }
}
