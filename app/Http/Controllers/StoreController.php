<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStore;
use App\Http\Requests\UpdateStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Exception;
use File;
use App\Store;
use App\StoreInventory;
use App\Product;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();
        return view('stores.index')
        ->with(
            [
                'title' => 'Lista de Almacenes', 'stores' => $stores,
                'new' => route('stores.create')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stores.create')
        ->with(
            [
                'title' => 'Nuevo Almacen'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStore $request)
    {

        DB::beginTransaction();

        try {

            Store::saveData($request);

        } catch (\Exception $e) {
            #dd($e);
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);

            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'La marca ha sido registrado con éxito.']);

        return redirect()->route('stores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $store = Store::findOrFail($id);
            $products = StoreInventory::where('store_id', $id)->get();

            $products->load('product');

            /*$products->each(function(&$item){
              $item->product = Product::findOrFail($item->product_id);
            });*/
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }

        return view('stores.show')
        ->with(
            [
                'title' => 'Información del almacén: '.$store->name,
                'store' => $store,
                'products' => $products,
                'new' => route('stores.create')
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = Store::findOrFail($id);

        return view('stores.edit')
        ->with(
            [
                'title' => 'Editar Información de la marca', 'store' => $store,
                'new' => route('stores.create')
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStore $request, $id)
    {
        DB::beginTransaction();

        try {
            Store::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('stores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $store = Store::findOrFail($id);

            Store::where('profile_id', $store->profile_id)->where('company_id', $store->company_id)->update(['default'=>0]);

            $item = Store::where('profile_id', $store->profile_id)->where('company_id', $store->company_id)->firstOrFail();

            $item->default = 1;

            $item->save();

            $store->delete();

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }


        return redirect()->route('stores.index');
    }

    public function getStores () {
      $stores = Store::all();

      return $stores;
    }

    public function transfer (Request $request) 
    {
        $v = Validator::make($request->all(), [
            'qty' => 'numeric|min:0|required'
        ]);

        if ($v->fails()) {
            return response()->json([
                $v->errors()
            ], 422);
        }

        try 
        {
            $fromStore = Store::findOrFail($request->fromStore);
            $toStore = Store::findOrFail($request->toStore);
        } 
        catch (ModelNotFoundException $e) 
        {
            return response()->json([
                'title' => 'Advertencia',
                'message' => 'Almacen no encontrado',
            ], 404);
        }
        $product = $request->product;
        
        $fromStore->load(['store_inventories' => function ($query) use ($product){
            $query->where('product_id', $product)->first();
        }]);

        $toStore->load(['store_inventories' => function ($query) use ($product){
            $query->where('product_id', $product)->first();
        }]);

        if ($fromStore->store_inventories->count() == 0) {
            return response()->json([
                'title' => 'Error',
                'message' => 'No se puede transferir el producto desde el almacén: '.$fromStore->name,
            ], 500);
        }

        if ($fromStore->store_inventories->first()->qty < $request->qty) {
            return response()->json([
                'title' => 'Advertencia',
                'message' => 'No puede, transferir una cantidad mayor a la disponible'
            ], 422);
        }

        if ($toStore->store_inventories->count() == 0) {
            $store_inventory = new StoreInventory;
            $product = Product::find($request->product);

            $store_inventory->qty = $request->qty;
            $store_inventory->store()->associate($toStore);
            $store_inventory->product()->associate($product);
        } 
        else 
        {
            $store_inventory = $toStore->store_inventories->first();
            $store_inventory->qty += $request->qty;
        }

        $fromStore->store_inventories->first()->qty -= $request->qty;

        DB::beginTransaction();

            try 
            {
                $fromStore->store_inventories->first()->save();
                $store_inventory->save();   
            } 
            catch (QueryException $e) 
            {
                DB::rollBack();
                return response()->json([
                    'title' => 'Error',
                    'message' => 'No se pudo realizar la transferencia'
                ], 500);
            }

        DB::commit();

        return response()->json([
            $request->all(), 
            'desde' => $fromStore,
            'hacia' => $toStore,
        ]);
    }
}
