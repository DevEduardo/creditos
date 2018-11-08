<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

use App\Http\Requests\OpenInvoice;

use Carbon\Carbon;

use App\Provider;
use App\Product;
use App\Store;
use App\Invoice;
use App\Tax;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('provider.profile')->get();

        return view('invoices.index')
        ->with(
            [
                'title' => 'Facturas',
                'new' => route('invoices.create'),
                'invoices' => $invoices
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
        $invoice = null;
        $created = !Invoice::where('finished', false)->where('user_id', Auth::id())->get()->isEmpty();

        if($created) {
            $invoice = Invoice::where('finished', "0")->where('user_id', Auth::id())->first();

            $invoice->invoice_details;
            $invoice->invoice_details->each(function($item){
                $item->product;
                $item->product->name = $item->product->name.' - '.$item->product->brand.' - '.$item->product->model;
            });

            $invoice->invoice_details->each(function($item){
                $item->invoice_detail_taxes;
            });
            
        }
        #$invoice = collect(['id' => 1]);

        $providers = Provider::select(DB::raw("CONCAT(cuit,' | ',name) AS cuit"),'id')->pluck('cuit', 'id')->toArray();
        $products = Product::select(DB::raw("CONCAT(code, ' - ', name, ' - ', brand, ' - ', model) AS name"), 'id')->pluck('name', 'id')->toArray();
        
        $taxes = Tax::select(DB::raw("CONCAT(name,' (',value, '%)') AS name"),'id')->pluck('name', 'id');
        $taxesj = Tax::all()->pluck('value', 'id');
        
        return view('invoices.create')
        ->with(
            [
                'title' => 'Facturas',
                'viewInvoice' => true,
                'providers' => $providers,
                'products'  => $products,
                'stores'    => Store::all(),
                'taxes'     => $taxes,
                'taxesj'     => json_encode($taxesj),
                'invoice'   => $invoice,
                'created'   => $created
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
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
        //
    }

    public function openInvoice(OpenInvoice $request)
    {

        $date = Carbon::createFromFormat('d/m/Y', $request->date);
        
        $exist = Invoice::where('code', $request->code)
                        ->where('date', 'like', $date->format('Y-') . "%")
                        ->where('provider_id', $request->provider_id)
                        ->get();

        if($exist->isNotEmpty()){
            return response()
                ->json(
                    ['_message' => 'La factura que intentas aperturar ya se encuentra registrada.',],
                     Response::HTTP_NOT_FOUND
                );
        }

        DB::beginTransaction();

        try {

            $invoice = Invoice::openInvoice($request);

        } catch (Exception $e) {

            DB::rollBack();
        }

        DB::commit();
        return response()->json(['_message' => 'Factura aperturada con éxito.', 'invoice' => $invoice]);
    }

    public function finishInvoice()
    {
        DB::beginTransaction();
        try {
            
            $invoice = Invoice::where('finished', false)->where('user_id', Auth::id())->first();

            if($invoice->invoice_details->isEmpty())
            {
                throw_if(true, \Exception::class, "Disculpe, debe agregar items antes de finalizar la factura.");
            }

            $invoice->invoice_details->each(function($item) use (&$arrayItems){

                \App\LoadInventory::syncWithInventory($item->product_id, $item->load_inventory->sum('qty'));

            });

            $invoice->finished = 1;
            $invoice->save();

        } catch (\Exception $e) {
            DB::rollback();

            throw_if(true, \Exception::class, "Disculpe, hubo un error al intentar finalizar la factura cargada.");
        }

        DB::commit();

        return response()->json([
            '_message' => 'Factura finalizada exitosamente.',
        ]);
    }

    public function cancelInvoice()
    {
        DB::beginTransaction();
        try {
            
            $invoice = Invoice::where('finished', false)->where('user_id', Auth::id())->first();

            $invoice->delete();

        } catch (\Exception $e) {
            DB::rollback();

            throw_if(true, \Exception::class, "Disculpe, hubo un error al intentar cancelar la factura cargada.");
        }

        DB::commit();

        return response()->json([
            '_message' => 'Factura cancelada exitosamente.',
        ]);
    }
}
