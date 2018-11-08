<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\SaleDetail;
use App\Inventory;

class SaleDetailController extends Controller
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
    public function store(Request $request)
    {
      DB::beginTransaction();

        $last = false;
        $inventory = Inventory::where('product_id', $request->product_id)->firstOrFail();

        if($inventory->qty == $request->qty)
        {
            $last = true;
        }
        
      try {

        $detail = SaleDetail::saveData($request);

        $sale = \App\Sale::findOrFail($request->sale_id);
        if(isset($sale))
      	{
      		$sale->load('client.client_type');
          $sale->sale_details;

          $subtotal = 0;
          $discount = 0;
          $total = 0;

          $sale->sale_details->each(function($item) use (&$subtotal, &$discount, &$total) {
              $item->product;
        
              $subtotal += ($item->price * $item->qty);
              $discount += $item->amount_discount;
              $total += $item->subtotal;
          });

          $sale->subtotal = $subtotal;
          $sale->discount_amount = $discount;
          $sale->total = $total;
          $sale->save();
      	}

        $sale->last_item = $last;

      } catch (Exception $e) {

        DB::rollback();

        return response()->json([
          '_message' => $e->getMessage(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

      }

      DB::commit();
      return response()->json($sale);
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
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {

          $detail = SaleDetail::findOrFail($request->id);

          $inventory = Inventory::where('product_id', $detail->product_id)->firstOrFail();
          $inventory->incrementQty($detail->product_id, $detail->qty);

          $detail->delete();

          $sale = \App\Sale::findOrFail($detail->sale_id);

          if(isset($sale))
        	{
        		$sale->client;
            $sale->sale_details;

            $sale->load('client.client_type');

            $subtotal = 0;
            $discount = 0;
            $total = 0;

            $sale->sale_details->each(function($item) use (&$subtotal, &$discount, &$total) {
              $item->product;
        
              $subtotal += ($item->price * $item->qty);
              $discount += $item->amount_discount;
              $total += $item->subtotal;
            });

            $sale->subtotal = $subtotal;
            $sale->discount_amount = $discount;
            $sale->total = $total;
            $sale->save();
        	}

        } catch (Exception $e) {

          DB::rollback();

          return response()->json([
            '_message' => $e->getMessage(),
          ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::commit();
        return response()->json($sale);
    }
}
