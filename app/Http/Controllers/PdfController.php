<?php

namespace App\Http\Controllers;

use PDF;
use App\Sale;
use App\Client;
use App\Coupon;
use App\Credit;
use App\Payment;
use App\Delivery;
use App\CouponGet;
use Carbon\Carbon;
use App\SaleDetail;
use NumerosEnLetras;
use App\CreditDetail;
use Illuminate\Http\Request;
use App\Exports\CouponExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PdfController extends Controller
{
    public function pdfContract($creditId)
    {
    	try {
    		$credit = Credit::findOrFail($creditId);
    	} catch (ModelNotFoundException $e) {
    		alert()->flash('Advertencia', 'warning', ['text' => 'El credito que busca no fue encontrado']);
    		return redirect()->back();
    	}

    	$credit->load('sale.sale_details.product', 'sale.client.profile.state', 'sale.client.profile.city', 'sale.client.client_type', 'credit_details');

        if ($credit->contract_print > 0 && ! session()->has('reprint-contract')) {
            return view('authorizations.reprint')->with([
                'title' => 'Autorización de reimpresion',
                'credit_id' => $credit->id,
                'type' => 'contract'
            ]);
        }

        $credit->contract_print ++;
        $credit->save();

        session()->has('reprint-contract') ? session()->forget('reprint-contract') : '';

    	$date = Carbon::now();

        if ($credit->sale->type == 'scooter' || $credit->sale->type == 'renovation') {
            $pdf = PDF::loadView('pdfs.contractShort', ['credit' => $credit, 'date' => $date]);
            $pdf->setPaper('letter');

            return $pdf->stream();
        }

    	$pdf = PDF::loadView('pdfs.contract', ['credit' => $credit, 'date' => $date]);
    	$pdf->setPaper('letter');

    	return $pdf->stream();
    }

    public function pdfSale($sale)
    {
        $sale = Sale::findOrFail($sale);

        $sale->load('credit', 'client', 'client.profile','sale_details.product');
        $date = Carbon::now()->format('d-m-Y h:m');

        $pdf = PDF::loadView('pdfs.contractSing', ['sale' => $sale, 'date' => $date]);
        $pdf->setPaper('letter');

        return $pdf->stream();
        
    }

    public function pdfDepartureOrder($creditId)
    {
        try {
            $credit = Credit::findOrFail($creditId);
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'El credito que busca no fue encontrado']);
            return redirect()->back();
        }

        $credit->load('sale.sale_details.product', 'sale.client.profile.state', 'sale.client.profile.city', 'sale.client.client_type', 'credit_details');

        if ($credit->departure_order_print > 0 && ! session()->has('reprint-departure-order')) {
            return view('authorizations.reprint')->with([
                'title' => 'Autorización de reimpresion',
                'credit_id' => $credit->id,
                'type' => 'departure-order'
            ]);
        }

        $credit->departure_order_print ++;
        $credit->save();

        session()->has('reprint-departure-order') ? session()->forget('reprint-departure-order') : '';

        $pdf = PDF::loadView('pdfs.departure_order', ['credit' => $credit]);
        $pdf->setPaper('letter');

        return $pdf->stream();
    }

    public function pdfRemit($saleId)
    {
        try {
            $sale = Sale::findOrFail($saleId);
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'La venta que busca no fue encontrada']);
            return redirect()->back();
        }

        try {
            $payment = Payment::where('concept', 'LIKE', '%"sale_id":'.$sale->id.'%')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'Hubo un problema al buscar la venta']);
            return redirect()->back();   
        }

        $sale->remito = 1;
        $sale->save();

        $sale->load('client.profile', 'sale_details.product');

        $pdf = PDF::loadView('pdfs.remit', ['sale' => $sale, 'payment' => $payment]);
        $pdf->setPaper('letter');

        return $pdf->stream();   
    }

    public function orderDispatch($delivery)
    {
        
        try {
           $delivery = Delivery::OrderDispatch($delivery);


           $products = SaleDetail::select('products.id', 'products.name','products.code', 'products.brand', 'products.description', 'products.color', 'products.model')
                                   ->join('products','products.id', '=', 'sale_details.product_id')
                                   ->where('sale_id',$delivery->sID)
                                   ->get();

            $pdf = PDF::loadView('pdfs.orderDelivery',['delivery' => $delivery, 'products' => $products]);
            return $pdf->stream();
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'La orden de que busca no fue encontrada']);
            return redirect()->back();
        }
    }

    public function couponSing($id)
    {
        try {
            $dataCoupon = CreditDetail::getCoupon($id);
            $credit = Credit::find($dataCoupon->creditID);
            $resta = $credit->sale->total - ($credit->payment_raw + $credit->advance_I + $credit->advance_II);
            $feeAmount  = $dataCoupon->fee_amount;
            $punitorios = ($dataCoupon->interest_to_expire == 'NULL')? $dataCoupon->interest_to_expire : 0;
            $total      = ($dataCoupon->interest_to_expire == 'NULL')? $dataCoupon->interest_to_expire + $dataCoupon->fee_amount : $dataCoupon->fee_amount;
            $quantity   = NumerosEnLetras::convertir($total);

            $nextFee   = CreditDetail::nextFee($dataCoupon->fee_number + 1, $dataCoupon->coupon + 1);

            $pdf = PDF::loadView('pdfs.couponPartial',[
                'dataCoupon' => $dataCoupon,
                'feeAmount'  => $feeAmount,
                'punitorios' => $punitorios,
                'total'      => $total,
                'quantity'   => $quantity,
                'resta'   => $resta,
                'nextFee'   => 0
            ]);
            $pdf->setPaper('legal');
            return $pdf->stream();
        } catch (Exception $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'La orden de que busca no fue encontrada']);
            return redirect()->back();
        }
    }

    public function couponSingAdvanceOne($id)
    {
        try {
            $data = Credit::find($id);
            $data->load('sale', 'sale.client', 'sale.client.profile');
            $code = $data->id.'-I';
            $punitorios = ($data->is_expired == 1)? $data->interest_expire : 0;
            $total      = ($data->is_expired == 1)? $data->interest_expire + $data->advance_I : $data->advance_I;
            $quantity   = NumerosEnLetras::convertir($total);
            $pdf = PDF::loadView('pdfs.couponAdvanceOne', [
                'code' => $code,
                'data' => $data,
                'punitorios' => $punitorios,
                'total' => $total,
                'quantity' => $quantity
            ]);
            $pdf->setPaper('legal');
            return $pdf->stream();
        } catch (Exception $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'La orden de que busca no fue encontrada']);
            return redirect()->back();
        }
    }

    public function couponSingAdvanceSecond($id)
    {
        try {
            $data = Credit::find($id);
            $data->load('sale', 'sale.client', 'sale.client.profile');
            $code = $data->id.'-II';
            $punitorios = ($data->is_expired == 1)? $data->interest_expire : 0;
            $total      = ($data->is_expired == 1)? $data->interest_expire + $data->advance_II : $data->advance_II;
            $quantity   = NumerosEnLetras::convertir($total);
            $pdf = PDF::loadView('pdfs.couponAdvanceSecond', [
                'code' => $code,
                'data' => $data,
                'punitorios' => $punitorios,
                'total' => $total,
                'quantity' => $quantity
            ]);
            $pdf->setPaper('legal');
            return $pdf->stream();
        } catch (Exception $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'La orden de que busca no fue encontrada']);
            return redirect()->back();
        }
        
    }

    public function coupon($id)
    {
        /*try {
            
            $data = CouponGet::where('fee_id', $id)->get();
            $data = $data->last();
            $client = Client::find($data->client_id);
            $credit = Credit::find($data->credit_id);
            $fee = CreditDetail::find( $id);
            if ($credit->fees == $fee->fee_number) {
                $nextFee = false;
            }else{
                $nextFee = CreditDetail::NextFee($fee->fee_number + 1,$fee->id +1);
            }
            

            $pdf = PDF::loadView('pdfs.coupon',[
                'data' => $data,
                'client' => $client,
                'credit' => $credit,
                'nextFee' => $nextFee,
                'fee' => $fee
            ]);
            $pdf->setPaper('b4');
            return $pdf->stream();
        } catch (Exception $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'La orden de que busca no fue encontrada']);
            return redirect()->back();
        }*/
        return Excel::download(new CouponExport, 'cupon.xlsx');
    }
}
