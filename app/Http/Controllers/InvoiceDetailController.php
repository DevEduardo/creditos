<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests\StoreInvoiceItem;

use App\Invoice;
use App\InvoiceDetail;
use App\StoreInventory;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceItem $request)
    {
        DB::beginTransaction();

        try {

            $invoice = InvoiceDetail::saveData($request);

        } catch (Exception $e) {

            DB::rollBack();

        }

        DB::commit();
        return response()->json(['_message' => 'Información almacenada.', 'invoice' => $invoice]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * Para eliminar un detalle de la factura, debemos atacar las siguientes tablas
         *
         * InvoiceDetail        [id, invoice_id]
         * InvoiceDetailTaxes   [invoice_detail_id]
         * StoreInventory :: Restar qty de InvoiceDetail
         * Product :: update_price = 0 :: next_price = 0.00
         *
         */
        
        $detail = null;

        DB::beginTransaction();

        try {
            
            $detail = InvoiceDetail::findOrFail($id);

            $detail->product->syncPriceRollback($detail->product);

            StoreInventory::rollbackInventory($detail);

            $detail->forceDelete();

            $invoice = Invoice::findOrFail($detail->invoice_id);

            $invoice->invoice_details;
            $invoice->invoice_details->each(function($item, $key){
                $item->product;
            });

            $invoice->invoice_details->each(function($item, $key){
                $item->invoice_detail_taxes;
            });

        } catch (Exception $e) {
            
            DB::rollback();

            throw_if(true, \Exception::class, "Item no encontrado.");

        }
        #DB::rollback();
        DB::commit();

        return response()->json([
            '_messaje' => 'Item eliminado exitosamente',
            '_delete' => 1,
            'invoice' => $invoice
        ]);
    }
}
