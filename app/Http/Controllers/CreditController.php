<?php

namespace App\Http\Controllers;

use App\Low;
use App\Sale;
use App\Token;
use Execption;
use App\Client;
use App\Credit;
use App\Company;
use App\Payment;
use App\Quoting;
use App\CouponGet;
use Carbon\Carbon;
use App\CreditDetail;
use App\Authorization;
use App\PaymentMethod;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Yajra\DataTables\CollectionDataTable;
use App\Http\Requests\PaySecondAdvanceRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreditController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$title = 'Lista';

        if ($request->get('opt') == 'sales') 
        {
            $title = 'Lista de Ventas realizadas';
        } 
        elseif($request->get('opt') == 'credits') 
        {
            $title = 'Lista de Creditos otorgados';
        } 
        elseif($request->get('opt') == 'motos') 
        {
            $title = 'Lista de Creditos otorgados de motos';
        } 
        elseif ($request->get('opt') == 'morosos') 
        {
            $title = 'Lista de Creditos en mora';
        }
        elseif ($request->get('opt') == 'morososSales') 
        {
            $title = 'Lista de Ventas adeudadas';
        }

        return view('credits.index')
        ->with(
            [
                'title' => $title, 
                'opt' => $request->get('opt'),
            ]
        );
    }

    public function getDateCredit($date, $dateEnd)
    {
        $title = 'Lista de credito';
        return view('credits.showCreditDate', compact('date', 'dateEnd', 'title'));
    } 

    public function getDateSales($date, $dateEnd)
    {
        $title = 'Lista de ventas';
        return view('credits.showSalesDate', compact('date', 'dateEnd', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
    	try {
            $sale_id 	= 	1;
            $sale 		= 	Sale::with('sale_details')->findOrFail($sale_id);
            $company 	= 	Company::with('company_info')->findOrFail($sale->company_id);
            $client 	= 	Client::with('client_type')->findOrFail($sale->client_id);

            $advance	=	$company->company_info->advance;

            $credit_advance =	(($sale->total * $advance)/100);
            $interest 	=	$company->company_info->interest;
            $max_fees 	= 	$client->client_type->max_fees;
            

        } catch (Exception $e) {
            
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error, esta compra no existe.']);
            
            return redirect()->back();
        }

       
        //return view('credits.create')->with(compact('title', 'sales'));
        return view('credits.create')->with(
            [
                'title'     => 'Nuevo Credito',
                'sale'	    =>  $sale,
                'interest'	=>	$interest,
                'max_fees'	=>	$max_fees,
                'credit_advance'	=>	$credit_advance,
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
        
        DB::beginTransaction();
        
        try {
            
            Credit::saveData($request);

        } catch (\Exception $e) {
            #dd($e);
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro se ha completado con éxito.']);

        return redirect()->route('credits.index');
        
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $date = Carbon::now();

        try {
            $credit = Credit::with('sale')->findOrFail($id);
            $credit_details = CreditDetail::where('credit_id', $id)->get();
            $lastPays = CreditDetail::where('credit_id', $id)->where('is_payed', 1)->get();
            $idLastPays = $lastPays->last();
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        $vars = [
            'title'             =>  'Información del crédito',
            'credit'            =>  $credit,
            'credit_details'    =>  $credit_details,
            'idLastPays'        =>  $idLastPays,
        ];

        if ($credit->type != 'sing' && $credit_details->last()->fee_date_expired->diffInYears($date) >= 1) {
            $vars['refinanceAmout'] = $this->refinanceAmout($credit_details, $credit->interest_expired);
        }
        return view('credits.show')->with($vars);
    }


    public function findFee ($id)
    {   
    	try { 
            $amount = 0;
    		$fee = CreditDetail::with('credit')->findOrFail($id);
            if ($fee->is_expired) {
                $amount = ($fee->fee_amount - $fee->payment);
                $amount = $amount * (1 + (($fee->credit->interest_expired * $fee->days_expired)/100));
            }
            #$payment_methods = PaymentMethod::orderBy('name', 'ASC')->pluck('name', 'id');
    	} catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }

        return view('credits.findFee')->with(
        	[
        		'title' 			=> 	'Pagar Cuota',
                'fee'               =>  $fee,
        		'amount'				=>	$amount,
                #'payment_methods'   =>  $payment_methods,
        		#'new' 				=> 	route('enterprises.create')
        	]
        );

    }

    public function payFee(Request $request)
    {
        //Busco el credito para saber de que tipo es
        $fee = CreditDetail::with('credit')->find($request->get('fee_id'));
        $feeLast = CreditDetail::with('credit')->find($request->get('fee_id') - 1);

        $credit = Credit:: findOrFail($fee->credit_id);

        if ($fee->fee_number > 1 && $feeLast->is_payed == 0) {
            alert()->flash('Error', 'warning', ['text' => 'Debes pagar la cuota anterior ('.$feeLast->fee_number.') antes de pagar esta']);
            return redirect()->route('credits.show', $fee->credit->id.'#fees');
        }

        if ($credit->status) {
            alert()->flash('Operacion no permitida!', 'warning', ['text' => 'No puede realizar la accion ya que el crédito se a dado de baja.']);
            return redirect()->route('credits.show', $fee->credit->id.'#fees');
        }

        if ($fee->credit->type == 'two_advance') {
            if ($fee->credit->advance_II != $fee->credit->advance_I) {
                alert()->flash('Error', 'warning', ['text' => 'Para este credito aun se debe pagar el segundo avance']);
                return redirect()->back();
            }
        }     

        try {
            
            $payFee = CreditDetail::payFee($request->all());

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }


        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro se ha completado con éxito.']);
       
        return redirect()->route('credits.show', $fee->credit->id.'#fees');
        
    }

    public function refinanceCredit(Credit $credit, Request $request)
    {
        $credit->load('credit_details', 'sale.client.client_type');

        $sale = $credit->sale;

        //Validacion de las cuotas
        if ($request->has('fees')) {
            if (!is_numeric($request->get('fees')) && $request->get('fees') != 'add') {
                try {
                    $auth = Authorization::join('tokens', 'tokens.id', '=', 'authorizations.token_id')
                    ->where('tokens.value', $request->get('fees'))
                    ->select('authorizations.*')
                    ->firstOrFail();    
                } catch (ModelNotFoundException $e) {
                    return redirect()->back();
                }

                $fees = $auth->value;
            } elseif(is_numeric($request->get('fees')) && ($request->get('fees') >= 1 && $request->get('fees') <= 12)) {

                $fees = $request->get('fees');

            } else {
                return redirect()->back();
            }   
        }

        $amount = $this->refinanceAmout($credit->credit_details, $credit->interest_expired);

        if ($request->has('advance_I')) {
            if ($request->get('way_sale') == 'two_advance') {
                $amount -= ($request->get('advance_I')*2);
            } else {
                $amount -= $request->get('advance_I');
            }
        }

        $nCredit = new Credit;

        $nCredit->fill($request->all());

        $nCredit->date_advance_I = Carbon::now();
        $nCredit->interest = $sale->client->client_type->interest;
        $nCredit->interest_expired = $sale->client->client_type->daily_interest;
        $nCredit->amount = $amount;
        $nCredit->type = $request->get('way_sale');
        $nCredit->fees = $fees;

        DB::beginTransaction();
        
        //$credit->sale()->dissociate();

        $nCredit->sale()->associate($sale);

        try 
        {
            $credit->delete();
            $nCredit->save();    
        } 
        catch (Exception $e) 
        {
            DB::rollback();

            alert()->flash('Advertencia', 'warning', ['text' => 'no se pudo refinanciar el credito']);
            return redirect()->back();
        }

        if (! $this->create_credit_details($nCredit, $request->get('first_fee'))) {
            DB::rollback();
            return redirect()->back();
        }

        DB::commit();

        alert()->flash('Completado', 'success', ['text' => 'Credito refinanciado']);

        return redirect()->route('credits.show', $nCredit->id);
    }

    public function clientWhithCredit()
    {   
        $title = 'Listado de Clientes con creditos';

        return view('credits.client-with-credit')->with('title', $title);
    }

    public function creditDatatable(Request $request)
    {   

        
        if ($request->get('opt') == 'sales') 
        {
            $sales = Sale::with('credit', 'client', 'sale_details.product', 'user')
                ->whereIn('type', ['sing', 'simple','online','others'])
                ->get();
        } 
        elseif($request->get('opt') == 'credits') 
        {
            $sales = Sale::with('credit', 'client', 'sale_details.product', 'user')
                ->join('credits', function ($join) {
                    $join->on('credits.sale_id', '=', 'sales.id')
                        ->where('credits.deleted_at', '=', null);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('credit_details')
                        ->whereRaw('credit_details.is_expired = 1')
                        ->whereRaw('credit_details.credit_id = credits.id');
                })
                ->whereNotIn('credits.type', ['sing', 'simple', 'online','others'])
                ->whereNotIn('sales.type', ['scooter'])
                ->select('sales.*')
                ->get();

        }elseif($request->get('opt') == 'motos') 
        {
            $sales = Sale::with('credit', 'client', 'sale_details.product', 'user')
                ->join('credits', function ($join) {
                    $join->on('credits.sale_id', '=', 'sales.id')
                        ->where('credits.deleted_at', '=', null);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('credit_details')
                        ->whereRaw('credit_details.is_expired = 1')
                        ->whereRaw('credit_details.credit_id = credits.id');
                })
                ->where('sales.type', 'scooter')
                ->select('sales.*')
                ->get();

        } 
        elseif ($request->get('opt') == 'morosos') 
        {
            $sales = Sale::with('credit', 'client', 'sale_details.product', 'user')
                ->join('credits', function ($join) {
                    $join->on('credits.sale_id', '=', 'sales.id')
                        ->where('credits.deleted_at', '=', null);
                })
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('credit_details')
                        ->whereRaw('credit_details.is_expired = 1')
                        ->whereRaw('credit_details.credit_id = credits.id');
                })
                ->whereNotIn('credits.type', ['sing', 'simple','online','others'])
                ->select('sales.*')
                ->get();
        }elseif($request->get('opt') == 'morososSales'){

            $salesForSing = Credit::where('type', '=', 'sing')->get();

            foreach ($salesForSing as $key => $value) {
                if(\Carbon\Carbon::now() > $value->date_advance_I->addDays(60)){ 
                    $credits = Credit::findOrFail($value->id); 
                    $credits->is_expired = 1;
                    $credits->save();
                }
            }

            $sales = Sale::with('credit', 'client', 'sale_details.product', 'user')
                ->join('credits', function ($join) {
                    $join->on('credits.sale_id', '=', 'sales.id')
                        ->where('credits.deleted_at', '=', null);
                })
                ->where('credits.type', '=', 'sing')
                ->where('credits.is_expired', '=', 1)
                ->select('sales.*')
                ->get();
        }

        return (new CollectionDataTable($sales))
            ->editColumn('final_amount', function($sale) {
                if (! empty($sale->credit)) 
                {
                    if ($sale->credit->type == 'sing') {
                        return number_format(($sale->total - ($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'))), 0, ',', '.');
                    }

                    return number_format(($sale->credit->final_amount - $sale->credit->payment_raw), 0, ',', '.');
                }

                return number_format($sale->total, 0, ',', '.');
            })
            ->editColumn('created_at', function($sale) {
                if ((! empty($sale->credit)) && (! empty($sale->credit->date_advance_I))) {
                    return $sale->credit->created_at->format('d-m-Y');
                }

                return $sale->created_at->format('d-m-Y');
            })
            ->editColumn('type', function($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->string_type;
                }

                return $sale->string_type;
            })
            ->addColumn('dni', function ($sale) {
                return $sale->client->dni;
            })
            ->addColumn('financial_amount', function ($sale) {
                if (! empty($sale->credit)) {
                    return number_format($sale->credit->financial_amount, 0, ',', '.');
                }

                return $sale->string_type;
            })
            ->addColumn('payment', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->type == 'sing') {
                        return number_format($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'), 0, ',', '.');
                    }
                    return $sale->credit->payment;
                }
                
                return number_format($sale->total, 0, ',', '.');
            })
            ->addColumn('fees', function ($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->fees;
                }

                return 'NO';
            }) 
            ->addColumn('is_payed', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->is_payed) {
                        return '<span class="label label-success">Pagado</span>';
                    } elseif ($sale->credit->status == 'unsubscribe') {
                        return '<span class="label label-danger">De baja</span>';
                    }

                    return '<span class="label label-warning">Por pagar</span>';
                }elseif($sale->finished == 0){
                    return '<span class="label label-danger">De baja</span>';
                }

                return '<span class="label label-success">Pagado</span>';
            }) 
            ->addColumn('name', function ($sale) {
                if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Master')) {
                    return $sale->user->name;
                }
            })
            ->addColumn('action', function ($sale) {
                if (! empty($sale->credit)) {
                    return view('buttons-datatables.creditDatatables-credits')->with('sale', $sale);
                } elseif ($sale->type == 'simple' || $sale->type == 'online' || $sale->type == 'others') {
                    return view('buttons-datatables.creditDatatables-simple')->with('sale', $sale);
                }
            })
            ->filter(function ($instance) {
                $instance->collection = $instance->collection->filter(function ($row) {
                    
                    $flag = true;

                    if (!empty(request('search')['value'])) {
                        $flag = false;
                    }
                
                    foreach ($row['sale_details'] as $detail) {
                        if (Str::contains(strtolower($detail['product']['name']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['description']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['specification']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['brand']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['model']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($row['client']['dni']), strtolower(request('search')['value']))) 
                        {
                            $flag = true;
                        }
                    }

                    return $flag;
                });
            })
            ->rawColumns(['action', 'finished', 'is_payed'])
            ->toJson();
    }

    public function clientsWithCreditDatatable()
    {   

        $clients = Client::with('sales.credit', 'profile', 'client_type')
            ->join('sales', 'sales.client_id', '=', 'clients.id')
            ->join('credits', 'credits.sale_id', '=', 'sales.id')
            ->whereNotIn('credits.type', ['sing', 'simple'])
            ->where('sales.deleted_at', null)
            //->where('credits.deleted_at', null)
            ->select('clients.*')
            ->distinct()
            ->get();

        return (new CollectionDataTable($clients))
            ->addColumn('quantity_credits', function ($client) {
                return $client->sales->whereNotIn('type', ['sing', 'simple'])->count();
            })
            ->addColumn('action', function ($client) {
                return '<div class="btn-group" role="group"><a href="'.route('credit.client', $client->id).'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> <i class="fa fa-eye"></i> </a>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function creditClient(Client $client)
    {
        $title = 'Listado de creditos del cliente';

        $client->load('profile');

        $credits =  Credit::with('credit_details')
            ->join('sales', 'sales.id', '=', 'credits.sale_id')
            ->join('clients', 'clients.id', '=', 'sales.client_id')
            ->where('clients.id', $client->id)
            ->whereNotIn('credits.type', ['sing', 'simple'])
            ->where('credits.is_payed',0)
            ->select('credits.*')
            ->get();

        return view('credits.client')->with(compact(
            'title',
            'client',
            'credits'
        ));
    }

    protected function refinanceAmout($credit_details, $interest_expired)
    {
        $amount = 0;

        //sumo todo los interes exipirados
        $credit_details->each(function ($detail) use (&$amount, $interest_expired) {
            $amount += ($detail->fee_amount * (1 + ($interest_expired/100))) * $detail->days_expired;
        });

        //resto el 90%
        $amount -= ($amount * 0.9);

        //sumo las cuotas puras
        $credit_details->each(function ($detail) use (&$amount) {
            $amount += $detail->fee_amount;
        });

        return round($amount);
    }

    private function create_credit_details($credit, $days = null)
    {   
        $date = Carbon::now();

        if ($days == null) {
            $days = 30;
        } elseif (! is_numeric($days)) {
        
            try {
                $auth = Authorization::where('token', $days)->firstOrFail();    
            } catch (ModelNotFoundException $e) {
                return false;
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
                $detail->fee_date_expired = $date->addDays($days*$i);
            } else {
                $detail->fee_date_expired = $date->addDays(30);
            }

            $detail->credit()->associate($credit);

            $detail->save();
        }

        $credit->final_amount = round($final_amount);
        $credit->save();

        return true;
    }

    /**
     * Metodo para el pago multiple de cuotas de distintos creditos
     * 
     * @param  Request $request
     * @return Response
     */
    public function multiCreditPay(Request $request)
    {
        $data = $request->all();

        foreach ($data['amount'] as $credit_id => $payment_amount) {

            //Busco el credito para saber de que tipo es
            $credit = Credit::find($credit_id);

            if ($credit->type == 'two_advance') {
                if ($credit->advance_II != $credit->advance_I) {
                    alert()->flash('Error', 'warning', ['text' => 'Uno de los creditos que intenta pagar aun debe el segundo avance']);
                    return redirect()->back();
                }
            }
        }

        DB::beginTransaction();
        foreach ($data['amount'] as $credit_id => $payment_amount) {

            $fee = CreditDetail::where([
                    ['credit_id', $credit_id],
                    ['is_payed', false]
                ])
                ->first();

            try {
                $payFee = CreditDetail::payFee([
                        'payment'   => $payment_amount,
                        'fee_id'    => $fee->id,
                        'way_to_pay' => $data['way_to_pay']
                    ]);
            } catch (Exception $e) {
                DB::rollback();
                alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
                return redirect()->back();
            }
        }
        DB::commit();

        alert()->flash('¡Pago Exitoso!', 'success', ['text' => 'El pago se ha completado con éxito.']);
        return redirect()->to('credit/'.$fee->credit->sale->user_id.'/client');
    }

    public function secondAdvance(Credit $credit, PaySecondAdvanceRequest $request)
    {
        $credit->load('credit_details');
        $payed = false;
        $firstPay = true;
        $CalculateAmount = ($credit->advance_I + $credit->advance_II + $request->get('advance_II') + $credit->credit_details->sum('fee_amount') - $credit->sale->total);
        
        if ($CalculateAmount < 0) {
            $amount = $CalculateAmount * (-1);
        }
        
        if ($credit->type == 'two_advance') {
            if ($request->get('advance_II') > $credit->advance_I) {
                alert()->flash('Advertencia', 'warning', ['text' => 'El monto del segundo avance no puede superar al del primero.']);
                return redirect()->back();
            }
        }

        if ($credit->type == 'sing') {
            if (! empty($credit->advance_II)) {
                $firstPay = false;
            }
            
            if (@$amount < 0) 
            {
                alert()->flash('Advertencia', 'warning', ['text' => 'El monto del segundo avance no puede superar al monto total de la venta.']);
                return redirect()->back();
            } 
            elseif ($credit->sale->total - ($credit->advance_I + $credit->advance_II + $credit->credit_details->sum('fee_amount') + $request->get('advance_II')) == 0)
            {
                $payed = true;
            }
        }

        $payment = new Payment;

        if (! $firstPay && $credit->type = 'sing') {
            DB::beginTransaction();

            try {
                $this->create_quota($credit, $request->get('advance_II'));
            } catch (QueryException $e) {
                DB::rollback();
                alert()->flash($e->getMessage(), 'warning', ['text' => 'Error al pagar la seña.']);
                return redirect()->back();
            }

            DB::commit();

            $creditDetails = CreditDetail::all();
            $payment->amount = $request->get('advance_II');
            $payment->type = 'credit_detail';
            $payment->way_to_pay = $request->get('way_to_pay');
            $payment->concept = json_encode([
                'credit_detail_id' => $creditDetails->last()->id,
                'add_info' => 'Pago de cuotas'
            ]);
            
        } else {

            $credit->advance_II = ($credit->advance_II + $request->get('advance_II'));
            $credit->date_advance_II = Carbon::now();

            $payment->amount = $request->get('advance_II');
            $payment->type = 'credit';
            $payment->way_to_pay = $request->get('way_to_pay');
            $payment->concept = json_encode([
                'credit_id' => $credit->id,
                'add_info' => 'Pago de segundo avance'
            ]);
        }

        if ($payed) {
            $credit->is_payed = true;
        }

        $payment->user()->associate(Auth::user());

        DB::beginTransaction();
        try {
            $credit->save();
            $payment->save();
        } catch (QueryException $e) {
            DB::rollback();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            //return redirect()->back();
        }

        DB::commit();
        alert()->flash('¡Pago Exitoso!', 'success', ['text' => 'El pago se ha completado con éxito.']);
        return redirect()->route('credits.show', $credit->id);
    }

    public function destroy(Credit $credit)
    {
        $opt = 'credits';

        try {
            $credit->delete();
        } catch (QueryException $e) {
            alert()->flash('Error', 'danger', ['text' => $e->getMessage()]);
            return redirect()->back();
        }

        if ($credit->type == 'sing') {
            $opt = 'sales';
        }

        alert()->flash('Completado', 'success', ['text' => 'Credito cancelado con éxito.']);
        return redirect()->route('credits.index', ['opt' => $opt]);
    }

    public function unsubscribe($id, $observation)
    {
        $opt = 'credits';

        try {
            $credit = Credit::findOrFail($id);   
        } catch (ModelNotFoundException $e) {
            alert()->flash('Advertencia', 'warning', ['text' => 'El credito que intenta dar de baja no fue encontrado.']);
            return redirect()->back();
        }

        if ($credit->is_payed) {
            alert()->flash('Advertencia', 'warning', ['text' => 'El credito que intenta dar de baja ya fue pagado.']);
            return redirect()->back();
        }

        $credit->status = 'unsubscribe';
        $credit->add_info = json_encode([
            'unsubscribe' => $observation,
            'user'        => Auth()->user()->name
        ]);
        $credit->discharge_at = date('Y-m-d');


        $credit->save();

        $low = new Low();
        $low->type = 0;
        $low->user = Auth()->user()->name;
        $low->amount = $credit->amount;
        $low->observation = $observation;
        $low->client_dni = $credit->sale->client->dni;
        $low->save();

        if ($credit->type == 'sing') {
            $opt = 'sales';
        }

        alert()->flash('Completado', 'success', ['text' => 'Credito dado de baja con exito']);
        return redirect()->route('credits.index', ['opt' => $opt]);
    }

    /**
    * Este metodo se encarga de crear la cuota para las señas a medida de que se va pagando
    */
    private function create_quota($credit, $amount)
    {
        $credit->load('credit_details');

        $quota = new CreditDetail;

        $quota->fee_number = ($credit->credit_details->count()+1);
        $quota->base_amount = $quota->fee_amount = $quota->payment = $amount;
        $quota->fee_date = $quota->fee_date_expired = Carbon::now();
        $quota->is_payed = true;

        $quota->credit()->associate($credit);

        $quota->save();
    }

    public function creditDatatableDate($date, $dateEnd)
    {
       
        $sales = Sale::with('credit', 'client', 'sale_details.product', 'user')
                ->join('credits', function ($join) {
                    $join->on('credits.sale_id', '=', 'sales.id')
                        ->where('credits.deleted_at', '=', null);
                })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('credit_details')
                        ->whereRaw('credit_details.is_expired = 1')
                        ->whereRaw('credit_details.credit_id = credits.id');
                })
                ->whereNotIn('credits.type', ['sing', 'simple', 'online','others'])
                ->whereDate('credits.created_at', '>=', $date)
                ->whereDate('credits.created_at', '<=', $dateEnd)
                ->select('sales.*')
                ->get();

        return (new CollectionDataTable($sales))
            ->editColumn('final_amount', function($sale) {
                if (! empty($sale->credit)) 
                {
                    if ($sale->credit->type == 'sing') {
                        return number_format(($sale->total - ($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'))), 0, ',', '.');
                    }

                    return number_format(($sale->credit->final_amount - $sale->credit->payment_raw), 0, ',', '.');
                }

                return number_format($sale->total, 0, ',', '.');
            })
            ->editColumn('created_at', function($sale) {
                if ((! empty($sale->credit)) && (! empty($sale->credit->date_advance_I))) {
                    return $sale->credit->created_at->format('d-m-Y');
                }

                return $sale->created_at->format('d-m-Y');
            })
            ->editColumn('type', function($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->string_type;
                }

                return $sale->string_type;
            })
            ->addColumn('dni', function ($sale) {
                return $sale->client->dni;
            })
            ->addColumn('financial_amount', function ($sale) {
                if (! empty($sale->credit)) {
                    return number_format($sale->credit->financial_amount, 0, ',', '.');
                }

                return $sale->string_type;
            })
            ->addColumn('payment', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->type == 'sing') {
                        return number_format($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'), 0, ',', '.');
                    }
                    return $sale->credit->payment;
                }
                
                return number_format($sale->total, 0, ',', '.');
            })
            ->addColumn('fees', function ($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->fees;
                }

                return 'NO';
            }) 
            ->addColumn('is_payed', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->is_payed) {
                        return '<span class="label label-success">Pagado</span>';
                    } elseif ($sale->credit->status == 'unsubscribe') {
                        return '<span class="label label-danger">De baja</span>';
                    }

                    return '<span class="label label-warning">Por pagar</span>';
                }

                return '<span class="label label-success">Pagado</span>';
            }) 
            ->addColumn('name', function ($sale) {
                if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Master')) {
                    return $sale->user->name;
                }
            })
            ->addColumn('action', function ($sale) {
                if (! empty($sale->credit)) {
                    return view('buttons-datatables.creditDatatables-credits')->with('sale', $sale);
                } elseif ($sale->type == 'simple' || $sale->type == 'online' || $sale->type == 'others') {
                    return view('buttons-datatables.creditDatatables-simple')->with('sale', $sale);
                }
            })
            ->filter(function ($instance) {
                $instance->collection = $instance->collection->filter(function ($row) {
                    
                    $flag = true;

                    if (!empty(request('search')['value'])) {
                        $flag = false;
                    }
                
                    foreach ($row['sale_details'] as $detail) {
                        if (Str::contains(strtolower($detail['product']['name']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['description']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['specification']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['brand']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['model']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($row['client']['dni']), strtolower(request('search')['value']))) 
                        {
                            $flag = true;
                        }
                    }

                    return $flag;
                });
            })
            ->rawColumns(['action', 'finished', 'is_payed'])
            ->toJson(); 
    }

    public function salesDatatableDate($date)
    {
       
        $sales = Sale::with('credit', 'client', 'sale_details.product', 'user')
                ->whereIn('type', ['sing', 'simple','online','others'])
                ->whereDate('created_at', $date)
                ->get();

        return (new CollectionDataTable($sales))
            ->editColumn('final_amount', function($sale) {
                if (! empty($sale->credit)) 
                {
                    if ($sale->credit->type == 'sing') {
                        return number_format(($sale->total - ($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'))), 0, ',', '.');
                    }

                    return number_format(($sale->credit->final_amount - $sale->credit->payment_raw), 0, ',', '.');
                }

                return number_format($sale->total, 0, ',', '.');
            })
            ->editColumn('created_at', function($sale) {
                if ((! empty($sale->credit)) && (! empty($sale->credit->date_advance_I))) {
                    return $sale->credit->created_at->format('d-m-Y');
                }

                return $sale->created_at->format('d-m-Y');
            })
            ->editColumn('type', function($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->string_type;
                }

                return $sale->string_type;
            })
            ->addColumn('dni', function ($sale) {
                return $sale->client->dni;
            })
            ->addColumn('financial_amount', function ($sale) {
                if (! empty($sale->credit)) {
                    return number_format($sale->credit->financial_amount, 0, ',', '.');
                }

                return $sale->string_type;
            })
            ->addColumn('payment', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->type == 'sing') {
                        return number_format($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'), 0, ',', '.');
                    }
                    return $sale->credit->payment;
                }
                
                return number_format($sale->total, 0, ',', '.');
            })
            ->addColumn('fees', function ($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->fees;
                }

                return 'NO';
            }) 
            ->addColumn('is_payed', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->is_payed) {
                        return '<span class="label label-success">Pagado</span>';
                    } elseif ($sale->credit->status == 'unsubscribe') {
                        return '<span class="label label-danger">De baja</span>';
                    }

                    return '<span class="label label-warning">Por pagar</span>';
                }

                return '<span class="label label-success">Pagado</span>';
            }) 
            ->addColumn('name', function ($sale) {
                if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Master')) {
                    return $sale->user->name;
                }
            })
            ->addColumn('action', function ($sale) {
                if (! empty($sale->credit)) {
                    return view('buttons-datatables.creditDatatables-credits')->with('sale', $sale);
                } elseif ($sale->type == 'simple' || $sale->type == 'online' || $sale->type == 'others') {
                    return view('buttons-datatables.creditDatatables-simple')->with('sale', $sale);
                }
            })
            ->filter(function ($instance) {
                $instance->collection = $instance->collection->filter(function ($row) {
                    
                    $flag = true;

                    if (!empty(request('search')['value'])) {
                        $flag = false;
                    }
                
                    foreach ($row['sale_details'] as $detail) {
                        if (Str::contains(strtolower($detail['product']['name']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['description']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['specification']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['brand']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['model']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($row['client']['dni']), strtolower(request('search')['value']))) 
                        {
                            $flag = true;
                        }
                    }

                    return $flag;
                });
            })
            ->rawColumns(['action', 'finished', 'is_payed'])
            ->toJson(); 
    }
    public function singDataTable()
    {
        $sales = Credit::where('type', '=', 'sing')->get();
        foreach ($sales as $key => $value) {
            if(\Carbon\Carbon::now() > $value->date_advance_I->addDays(10)){ 
                $credit = Credit::findOrFail($value->id); 
                $credit->is_expired = 1;
                $credit->save();
            }
        }
        $salesForSing = Credit::where('type', '=', 'sing')->where('is_expired', '=', 1)->get();

        return (new CollectionDataTable($salesForSing))
            ->editColumn('final_amount', function($sale) {
                if (! empty($sale->credit)) 
                {
                    if ($sale->credit->type == 'sing') {
                        return number_format(($sale->total - ($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'))), 0, ',', '.');
                    }

                    return number_format(($sale->credit->final_amount - $sale->credit->payment_raw), 0, ',', '.');
                }

                return number_format($sale->total, 0, ',', '.');
            })
            ->editColumn('created_at', function($sale) {
                if ((! empty($sale->credit)) && (! empty($sale->credit->date_advance_I))) {
                    return $sale->credit->created_at->format('d-m-Y');
                }

                return $sale->created_at->format('d-m-Y');
            })
            ->editColumn('type', function($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->string_type;
                }

                return $sale->string_type;
            })
            ->addColumn('dni', function ($sale) {
                return $sale->client->dni;
            })
            ->addColumn('financial_amount', function ($sale) {
                if (! empty($sale->credit)) {
                    return number_format($sale->credit->financial_amount, 0, ',', '.');
                }

                return $sale->string_type;
            })
            ->addColumn('payment', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->type == 'sing') {
                        return number_format($sale->credit->advance_I + $sale->credit->advance_II + $sale->credit->credit_details->sum('fee_amount'), 0, ',', '.');
                    }
                    return $sale->credit->payment;
                }
                
                return number_format($sale->total, 0, ',', '.');
            })
            ->addColumn('fees', function ($sale) {
                if (! empty($sale->credit)) {
                    return $sale->credit->fees;
                }

                return 'NO';
            }) 
            ->addColumn('is_payed', function ($sale) {
                if (! empty($sale->credit)) {
                    if ($sale->credit->is_payed) {
                        return '<span class="label label-success">Pagado</span>';
                    } elseif ($sale->credit->status == 'unsubscribe') {
                        return '<span class="label label-danger">De baja</span>';
                    }

                    return '<span class="label label-warning">Por pagar</span>';
                }

                return '<span class="label label-success">Pagado</span>';
            }) 
            ->addColumn('name', function ($sale) {
                if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Master')) {
                    return $sale->user->name;
                }
            })
            ->addColumn('action', function ($sale) {
                if (! empty($sale->credit)) {
                    return view('buttons-datatables.creditDatatables-credits')->with('sale', $sale);
                } elseif ($sale->type == 'simple' || $sale->type == 'online' || $sale->type == 'others') {
                    return view('buttons-datatables.creditDatatables-simple')->with('sale', $sale);
                }
            })
            ->filter(function ($instance) {
                $instance->collection = $instance->collection->filter(function ($row) {
                    
                    $flag = true;

                    if (!empty(request('search')['value'])) {
                        $flag = false;
                    }
                
                    foreach ($row['sale_details'] as $detail) {
                        if (Str::contains(strtolower($detail['product']['name']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['description']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['specification']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['brand']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($detail['product']['model']), strtolower(request('search')['value']))
                            || Str::contains(strtolower($row['client']['dni']), strtolower(request('search')['value']))) 
                        {
                            $flag = true;
                        }
                    }

                    return $flag;
                });
            })
            ->rawColumns(['action', 'finished', 'is_payed'])
            ->toJson(); 
    }

    public function lastPays($request)
    {
        $fee = CreditDetail::findOrFail($request['share_id']);
        $credit = Credit::findOrFail($fee->credit_id); 
        
        if ($credit->status) {
            
            return false;
        }
        $discount = $fee['payment'] - $request['discountAmount'];

        if ($discount == 0) {
            $discount = null;
        }

        $fee->is_payed = 0;
        $fee->payment  = $discount;
        $fee->fee_date = null;
        $fee->save();

        $low = new Low();
        $low->type = 1;
        $low->user = Auth()->user()->name;
        $low->amount = $request['discountAmount'];
        $low->observation = 'Cupon de pago';
        $low->client_dni = $credit->sale->client->dni;
        $low->save();
        
        $credit->is_payed = 0;
        $credit->save();
        return true;
    }

    public function simulate()
    {   
        $share = Quoting::all();
        $shareHogar = Quoting::where('type',0)->get();
        $shareScooter = Quoting::where('type',1)->get();
        $title = 'Simulador de credito';
        return view('credits.simulates',compact('title','share','shareHogar', 'shareScooter'));
    }

    public function sharePorcentage(Request $request)
    {   

        $share = Quoting::where('type', $request->type)->get();
        if ($share->count() > 0) {
            foreach ($request->porcentage as $key => $value) {
                $porcentage = Quoting::where('type', $request->type)->where('share', ($key + 1))->first();
                $porcentage->type = $request->type;
                $porcentage->share = ($key + 1);
                $porcentage->porcentage = $value;
                $porcentage->save();
            }
        }else{
            foreach ($request->porcentage as $key2 => $value2) {
                $porcentage = new Quoting;
                $porcentage->type = $request->type;
                $porcentage->share = ($key2 + 1);
                $porcentage->porcentage = $value2;
                $porcentage->save();
            }
        }
        
        alert()->flash('Completado', 'success', ['text' => 'Porcentajes agregados con éxito.']);
        return redirect()->route('credit.simulate');
    }
}
