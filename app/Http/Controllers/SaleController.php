<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Low;
use App\Sale;
use App\User;
use App\Credit;
use App\Inventory;
use App\Delivery;
use App\Tax;
use App\Company;
use App\CreditDetail;
use App\Authorization;
use App\Token;
use App\Payment;
use App\ClientType;

use App\Rules\MinAdvance;
use App\Rules\MaxAdvance;
use App\Rules\MinInterest;
use App\Rules\MinInterestExpired;
use App\Rules\CreditLimit;

class SaleController extends Controller
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
    public function create(Request $request)
    {
        if (! $request->has('opt')) {
            alert()->flash('Advertencia', 'warning', ['text' => 'Seleccione el tipo de venta que desea efectuar']);
            return redirect()->route('credits.index');
        }

        switch ($request->get('opt')) {
            case 'high':
                $type_credit = [
                    'credit' => 'Cr&eacute;dito (Un Anticipo)',
                    'two_advance' => 'Cr&eacute;dito (Doble Anticipo) ',
                    'without_advance' => 'Créditos a 0/30/60/90'
                ];
                break;

            case 'renovation':
                $type_credit = [
                    'credit' => 'Cr&eacute;dito (Un Anticipo)',
                    'two_advance' => 'Cr&eacute;dito (Doble Anticipo) ',
                    'without_advance' => 'Créditos a 0/30/60/90'
                ];
                break;

            case 'sing':
                $type_credit = [
                    'sing' => 'Seña (Dos partes)', 
                ];
                break;

            case 'simple':
                $type_credit = [
                    'simple' => 'Venta directa', 
                ];
                break;
            case 'online':
                $type_credit = [
                    'online' => 'Venta online', 
                ];
                break;
            case 'others':
                $type_credit = [
                    'others' => 'Venta otras cuentas', 
                ];
                break;

            case 'scooter':
                $type_credit = [
                    'credit' => 'Cr&eacute;dito (Un Anticipo)',
                    'two_advance' => 'Cr&eacute;dito (Doble Anticipo) ',
                    'without_advance' => 'Créditos a 0/30/60/90'
                ];
                break;

            
            default:
                alert()->flash('Advertencia', 'warning', ['text' => 'El tipo de venta seleccionado no esta soportado']);
                return redirect()->route('credits.index');
                break;
        }

        $id = null;
      	$sale = \App\Sale::where('finished', 0)
            ->where('user_id', Auth::id())
            ->where('type', $request->get('opt'))
            ->whereNull('deleted_at')
            ->first();

        if(isset($sale))
        {
            $sale->sale_details;
            $sale->sale_details->each(function($item, $key){
                $item->product;
            });

            $id = $sale->id;

            $sale->load('credit', 'client.client_type');

            $sale->client->first_fee = $sale->client->first_fee;

            if ($sale->has('credit') && !empty($sale->credit)) {
                return redirect()->route('sale.preview', $sale->id);
            }
        }


        $taxes = Tax::select(DB::raw("CONCAT(name,' (',value, '%)') AS name"),'id')->pluck('name', 'id');

        return view('sales.create')->with([
        	'title' => 'Ventas',
        	'new' => route('sales.create'),
        	'viewInvoice' => true,
        	'sale' => json_encode($sale),
            'sale_id' => $id,
            'taxes' => $taxes,
            'type_credit' => $type_credit,
            'type_sale'   => $request->get('opt')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    	try {
    		$client = \App\Client::findOrFail($request->client_id);
    	} catch (\Exception $e) {
    		return response()->json([
        		'_message' => 'Cliente no encontrado'
        	], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    	}

    	try {
    		$company = \App\Company::findOrFail(1);
    	} catch (\Exception $e) {
    		return response()->json([
        		'_message' => 'Compañia no encontrado'
        	], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    	}


    	try {
    		$sale = new \App\Sale();
    		$date = new \Carbon\Carbon();

    		if( !Auth::check())
			{
                return response()->json([
                	'_message'	=> 'Su sesión ha expirado',
                	'reload'	=> 1
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
			}

			$sale->date       = $date->format('Y-m-d');
			$sale->company_id = $company->id;
			$sale->user_id    = Auth::id();
			$sale->client_id  = $client->id;
            $sale->type       = $request->get('type');

			$sale->save();

        $sale->load('credit', 'client.client_type');

    	} catch (Exception $e) {

    		return response()->json([
        		'_message' => 'Venta no apertura, por favor, intentelo de nuevo.'
        	]);

    	}

      return response()->json([
      	'_message' => 'Venta aperturada exitosamente.',
      	'sale' => $sale
      ]);
    }

    /**
     * [validationFormCredit description]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function validationFormCredit(Request $request)
    {
        $auth = null;

        if ($request->has('auth_limit_credit')) {
           $auth = $request->get('auth_limit_credit');
        }

        $v = Validator::make($request->all(), [
            'way_sale' => ['required'],
            'advance_I' => [
                'bail',
                'required_if:way_sale,credit,two_advance,sing', 
                new MinAdvance($request->get('way_sale'), $auth, $request->get('type_sale')), 
                new MaxAdvance($request->get('way_sale'), $request->get('type_sale')), 
                new CreditLimit($auth, $request->get('type_sale'))
            ],
            'fees'  => 'required_if:way_sale,credit,two_advance,without_advance',
            'way_to_pay' => 'required_if:way_sale,sing,credit,two_advance||required_if:first_fee,0',
            'first_fee' => 'required_if:way_sale,without_advance'
        ], [
            'way_sale.required' => 'Debe seleccionar un tipo de venta',
            'advance_I.required_if' => 'Debe colocar el monto del anticipo',
            'fees.required_if' => 'Debe seleccionar el número de cuotas',
            'way_to_pay.required_if' => 'Debe seleccionar el método de pago',
            'first_fee.required_if' => 'Debe seleccionar cuando se hara el pago de la primera cuota; en dias.'
        ]);

        if ($v->fails()) {
            return response()->json([
                $v->errors()
            ], 422);
        }

        return response()->json([
            'OK' => true
        ], 200);
    }

    public function finished(Request $request)
    {
        if ($request->get('type_sale') == 'simple') {
            if($this->finishedSimpleSale($request->get('way_to_pay')))
            {
                alert()->flash('Completado', 'success', ['text' => 'Venta realizada con exito.']);
                return redirect()->route('credits.index', ['opt' => 'sales']);
            }

            alert()->flash('Advertencia', 'warning', ['text' => 'Venta no completada.']);
            return redirect()->route('sales.create', ['opt' => $request->get('type_sale')]);
        }

        if ($request->get('type_sale') == 'online') {
            if($this->finishedOnlineSale())
            {
                alert()->flash('Completado', 'success', ['text' => 'Venta realizada con exito.']);
                return redirect()->route('credits.index', ['opt' => 'sales']);
            }

            alert()->flash('Advertencia', 'warning', ['text' => 'Venta no completada.']);
            return redirect()->route('sales.create', ['opt' => $request->get('type_sale')]);
        }

        if ($request->get('type_sale') == 'others') {
            if($this->finishedOthersSale())
            {
                alert()->flash('Completado', 'success', ['text' => 'Venta realizada con exito.']);
                return redirect()->route('credits.index', ['opt' => 'sales']);
            }

            alert()->flash('Advertencia', 'warning', ['text' => 'Venta no completada.']);
            return redirect()->route('sales.create', ['opt' => $request->get('type_sale')]);
        }

        $auth = null;
        
        if ($request->has('auth_limit_credit')) {
           $auth = $request->get('auth_limit_credit');
        }

        $v = Validator::make($request->all(), [
            'way_sale' => ['required'],
            'advance_I' => [
                'required_if:way_sale,credit,two_advance,sing', 
                new MinAdvance($request->get('way_sale'), $auth, $request->get('type_sale')), 
                new MaxAdvance($request->get('way_sale'), $request->get('type_sale')), 
                new CreditLimit($auth, $request->get('type_sale'))
            ],
            'fees'  => 'required_if:way_sale,credit,two_advance,without_advance',
            'way_to_pay' => 'required_if:way_sale,sing,credit,two_advance|required_if:first_fee,0',
            'first_fee' => 'required_if:way_sale,without_advance'
        ], [
            'way_sale.required' => 'Debe seleccionar un tipo de venta',
            'advance_I.required_if' => 'Debe colocar el monto del anticipo',
            'fees.required_if' => 'Debe seleccionar el número de cuotas',
            'way_to_pay.required_if' => 'Debe seleccionar el método de pago',
            'first_fee.required_if' => 'Debe seleccionar cuando se hara el pago de la primera cuota; en dias.'
        ]);

        if ($v->fails()) {
            return redirect()->route('sales.create', ['opt' => $request->get('type_sale')])
                ->withErrors($v)
                ->withInput();
        }

        if ($request->has('auth_limit_credit')) {
           $auth = $this->authLimitCredit($request->get('auth_limit_credit'), $request->get('type_sale'));
        }

        $fees = null;

        //Validacion de las cuotas
        if ($request->has('fees')) {
            if (!is_numeric($request->get('fees')) && $request->get('fees') != 'add') {
                try {
                    $auth = Authorization::join('tokens', 'tokens.id', '=', 'authorizations.token_id')
                    ->where('tokens.value', $request->get('fees'))
                    ->select('authorizations.*')
                    ->firstOrFail();    
                } catch (ModelNotFoundException $e) {
                    return redirect()->route('sales.create');
                }

                $fees = $auth->value;
            } elseif(is_numeric($request->get('fees')) && ($request->get('fees') >= 1 && $request->get('fees') <= 12)) {

                $fees = $request->get('fees');

            } else {
                return redirect()->route('sales.create');
            }   
        }
        
        DB::beginTransaction();
        
        try {

            $sale = Sale::where([
                ['finished', 0],
                ['user_id', Auth::id()],
                ['type', $request->get('type_sale')]
            ])->whereNull('deleted_at')->firstOrFail();

            $sale->load('client.client_type');

            $credit = new Credit;

            $amount = $sale->total;

            if ($request->has('advance_I')) {
                if ($request->get('way_sale') == 'two_advance') {
                    $amount -= ($request->get('advance_I')/2);
                } else {
                    $amount -= $request->get('advance_I');
                }
            }

            $surcharge = 1+($sale->client->client_type->surcharge/100);

            $credit->fill($request->all());

            if ($request->get('way_sale') == 'two_advance') {
                $credit->advance_I = ($request->get('advance_I')/2);
            }

            $credit->interest = $sale->client->client_type->interest;
            $credit->interest_expired = $sale->client->client_type->daily_interest;

            if ($request->get('type_sale') == 'scooter') {
                $ct = ClientType::find(3);

                $credit->interest = $ct->interest;
                $credit->interest_expired = $ct->daily_interest;
            } 

            if ($request->get('way_sale') != 'sing') {
                $amount = round($amount*$surcharge);
            }
            
            $credit->amount = $amount;

            if ($request->get('way_sale') != 'without_advance') {
                $credit->date_advance_I = date('Y-m-d');
            }

          $credit->type = $request->get('way_sale');
          $credit->fees = $fees;

          $credit->sale()->associate($sale);

          $credit->save();

          if (!empty($fees)) {
            $this->create_credit_details($credit, $request->get('first_fee'));
          }

        } catch (Exception $e) {
              DB::rollback();
              return response()->json([
                '_message'	=> 'La venta no pudo ser finalizada.',
              ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::commit();

        return redirect()->route('sale.preview', $sale->id);
    }

    private function finishedSimpleSale($way_to_pay)
    {   
        try 
        {
            $sale = Sale::where([
                ['finished', 0],
                ['user_id', Auth::id()],
                ['type', 'simple']
            ])->whereNull('deleted_at')->firstOrFail();
        } 
        catch (Exception $e) 
        {
            return false;
        }

        DB::beginTransaction();

        $sale->finished = 1;

        try {
            $delivery = Delivery::saveDelivery($sale->id, $sale->user_id);
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }

        $payment = new Payment;

        $payment->amount = $sale->total;
        $payment->type = $sale->type;
        $payment->way_to_pay = $way_to_pay;
        $payment->concept = json_encode([
            'sale_id' => $sale->id,
            'add_info' => 'Venta directa'
        ]);

        $payment->user()->associate(Auth::user());

        $payment->save();

        try {
            $sale->save();
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }

        DB::commit();

        return true;
    }

    private function finishedOnlineSale()
    {   
        try 
        {
            $sale = Sale::where([
                ['finished', 0],
                ['user_id', Auth::id()],
                ['type', 'online']
            ])->whereNull('deleted_at')->firstOrFail();
        } 
        catch (Exception $e) 
        {
            return false;
        }

        DB::beginTransaction();

        $sale->finished = 1;

        try {
            $delivery = Delivery::saveDelivery($sale->id, $sale->user_id);
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }

        $payment = new Payment;

        $payment->amount = $sale->total;
        $payment->type = $sale->type;
        $payment->way_to_pay = 'online';
        $payment->concept = json_encode([
            'sale_id' => $sale->id,
            'add_info' => 'Venta online'
        ]);

        $payment->user()->associate(Auth::user());

        $payment->save();

        try {
            $sale->save();
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }

        DB::commit();

        return true;
    }

    private function finishedOthersSale()
    {   
        try 
        {
            $sale = Sale::where([
                ['finished', 0],
                ['user_id', Auth::id()],
                ['type', 'others']
            ])->whereNull('deleted_at')->firstOrFail();
        } 
        catch (Exception $e) 
        {
            return false;
        }

        DB::beginTransaction();

        $sale->finished = 1;

        try {
            $delivery = Delivery::saveDelivery($sale->id, $sale->user_id);
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }

        $payment = new Payment;

        $payment->amount = $sale->total;
        $payment->type = $sale->type;
        $payment->way_to_pay = 'others';
        $payment->concept = json_encode([
            'sale_id' => $sale->id,
            'add_info' => 'Venta otras cuentas'
        ]);

        $payment->user()->associate(Auth::user());

        $payment->save();

        try {
            $sale->save();
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }

        DB::commit();

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $title = 'Información de la venta';
        return view('sales.show')->with(compact('sale', 'title'));
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
        
        $sale = Sale::findOrFail($id);

        if ($request->get('process') != 0) 
        {
            $payment = new Payment;

            $payment->amount = $sale->credit->advance_I;
            $payment->type = 'credit';
            $payment->way_to_pay = $sale->credit->way_to_pay;
            $payment->concept = json_encode([
                'credit_id' => $sale->credit->id,
                'add_info' => 'avance del credito'
            ]);

            $sale->finished = 1;
            $delivery = Delivery::saveDelivery($sale->id, $sale->user_id);

            $first_fee = $sale->credit->credit_details->first();

            if ($sale->credit->type == 'without_advance') 
            {
                $payment->amount = 0;

                if (! empty($first_fee) && $first_fee->fee_date_expired->diffInDays(Carbon::now()) == 0) {
                    $this->payFee($first_fee);
                }
            }

            $sale->save();

            $opt = 'credits';

            if ($sale->credit->type == 'simple' || $sale->credit->type == 'sing') {
                $payment->type = $sale->credit->type;
                $opt = 'sales';
            }

            $payment->user()->associate(Auth::user());
            $payment->save();

            alert()->flash('Completado', 'success', ['text' => 'Credito creado con éxito.']);
            return redirect()->route('credits.index', ['opt' => $opt]);
        } 
        elseif($request->get('process') == 0) 
        {
            $sale->credit->credit_details->each(function($detail) {
                $detail->delete();
            });

            $sale->credit->delete();

            $sale->save();

            alert()->flash('Advertencia', 'warning', ['text' => 'Credito Cancelado']);
            return redirect()->route('sales.create', ['opt' => $sale->type]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $sale = Sale::findOrFail($id);
            $sale->sale_details;
            $sale->sale_details->each(function($item){

                $inventory = Inventory::where('product_id', $item->product_id)->first();
                $inventory->incrementQty($item->product_id, $item->qty);
            });

            $sale->delete();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
              '_message' => $e->getMessage(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        DB::commit();
        return response()->json([
          'message' => 'Venta anulada'
        ]);
    }

    private function create_credit_details($credit, $days = null)
    {   
        $date = Carbon::now();

        if ($days == null || $days == 30) {
            $days = 1;
        } elseif ($days == 60) {
            $days = 2;
        } elseif ($days == 90) {
            $days = 3;
        } elseif (! is_numeric($days) && ! is_integer($days) && $days != 0) {
        
            try {
                $auth = Authorization::join('tokens', 'tokens.id', '=', 'authorizations.token_id')
                    ->where('tokens.value', $days)
                    ->select('authorizations.*')
                    ->firstOrFail();    
            } catch (ModelNotFoundException $e) {
                return redirect()->route('sales.create');
            }

            $days = $auth->value;
        }

        $amount = $credit->amount/$credit->fees;
        $final_amount = 0;

        for ($i = 1; $i <= $credit->fees; $i++) { 
            $detail = new CreditDetail;

            $detail->fee_number = $i;
            $detail->base_amount = $amount;
            $detail->fee_amount = round($amount*(1 + (json_decode($credit->interest, true)[$credit->fees-1]/100)));
            $final_amount += $detail->fee_amount;
            if ($i == 1) {
                $detail->fee_date_expired = $date->addMonths($days*$i);
            } else {
                $detail->fee_date_expired = $date->addMonth();
            }

            $detail->credit()->associate($credit);

            $detail->save();
        }

        $credit->final_amount = round($final_amount);
        $credit->save();
    }

    public function salePreview(Sale $sale)
    {
        $title = 'Vista Previa del Cr&eacute;dito';
        $sale->load('client.profile', 'credit.credit_details', 'sale_details');
        $company = Company::with('profile', 'company_info')->firstOrFail();

        if (! empty($sale->credit) && $sale->credit->credit_details->count() > 0) {

            $first_fee = $sale->credit->credit_details->first();

            if ($first_fee->fee_date_expired->diffInDays(Carbon::now()) == 0) {
                $first_fee->is_payed = true;
            }
        }

        return view('sales.preview')->with(compact('sale', 'title', 'company'));
    }

    public function authLimitCredit($clave, $type_sale)
    {
        try {
            $token = Token::where('value', $clave)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'error', ['text' => 'El código de autorización no coincide con ninguno registrado.']);
            return redirect()->route('sales.create');
        }

        $token->load('authorization');

        if (! empty($token->authorization)) {
            alert()->flash('Advertencia', 'error', ['text' => 'La clave de authorizacion ya fue utilizada.']);
            return redirect()->route('sales.create');
        }

        try {
            $sale = Sale::where([
                ['finished', 0],
                ['user_id', Auth::id()],
                ['type', $type_sale]
            ])->whereNull('deleted_at')->firstOrFail();   
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'error', ['text' => 'No existe ninguna venta aperturada.']);
            return redirect()->route('sales.create');
        }

        $authorization = new Authorization;

        $authorization->value = '1';
        $authorization->type = 'auth limit credit';
        $authorization->token()->associate($token);
        $authorization->sale()->associate($sale);

        $authorization->save();

        return $authorization->token->value;
    }

    private function payFee($fee)
    {
        $fee->update([
            'payment' => $fee->fee_amount,
            'is_payed' => true, 
            'fee_date' => Carbon::now()->format('Y-m-d')
        ]);

        Credit::updatePayment($fee);

        $payment = new Payment;

        $payment->amount = $fee->fee_amount;
        $payment->type = 'credit';
        $payment->way_to_pay = $fee->credit->way_to_pay;
        $payment->concept = json_encode([
            'credit_id' => $fee->credit->id,
            'add_info' => 'Pago de cuotas'
        ]);

        $payment->user()->associate(Auth::user());
        $payment->save();
    }

    public function unsubscribe($id, $observation)
    {

        try {
            $sale = Sale::findOrFail($id);   
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'La venta que intenta dar de baja no fue encontrado.']);
            return redirect()->back();
        }

        $sale->finished = 0;
        $sale->save();

        $low = new Low();
        $low->type = 2;
        $low->user = Auth()->user()->name;
        $low->amount = $sale->total;
        $low->observation = $observation;
        $low->client_dni = $sale->client->dni;
        $low->save();

        alert()->flash('Completado', 'success', ['text' => 'Credito dado de baja con exito']);
        return redirect()->route('credits.index', ['opt' => 'sales']);
    }



}