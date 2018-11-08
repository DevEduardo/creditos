<?php

namespace App\Http\Controllers;

use App\User;
use App\Sale;
use App\Token;
use App\Credit;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\SaleController;
use App\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorizationController extends Controller
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
        $v = Validator::make($request->all(), [
            'value' => 'required',
            'clave' => 'required',
            'type' => 'required'
        ], [
            'value.required' => 'Debe seleccionar el valor a autorizar',
            'clave.required' => 'Debe ingresar el código de autorización',
            'type.required' => 'Debe enviar el tipo de autorizacion'
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors(),
            ], 422);
        }

        try {
            $token = Token::where('value', $request->get('clave'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'title' => 'Error',
                'message' => 'El código de autorización no coincide con ninguno registrado',
            ], 403);
        }

        $token->load('authorization');

        if (! empty($token->authorization)) {
            return response()->json([
                'title' => 'Error',
                'message' => 'La clave de authorizacion ya fue utilizada.',
            ], 403);
        }

        try {
            $sale = Sale::where([
                ['finished', 0],
                ['user_id', Auth::id()]
            ])->whereNull('deleted_at')->firstOrFail();   
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'title' => 'Error',
                'message' => 'No existe ninguna venta aperturada',
            ], 404);
        }

        $authorization = new Authorization;

        $authorization->value = $request->get('value');
        $authorization->type = $request->get('type');
        $authorization->token()->associate($token);
        $authorization->sale()->associate($sale);

        try {
            $authorization->save();
        } catch (QueryException $e) {
            return response()->json([
                'title' => 'Error',
                'message' => 'No se pudo autorizar',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'title' => 'Completado',
            'message' => 'Se ha completado la autorización de manera exitosa',
            'cuotas' => $authorization->value,
            'token' => $token->value,
            'OK' => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Authorization  $authorization
     * @return \Illuminate\Http\Response
     */
    public function show(Authorization $authorization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Authorization  $authorization
     * @return \Illuminate\Http\Response
     */
    public function edit(Authorization $authorization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Authorization  $authorization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Authorization $authorization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Authorization  $authorization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authorization $authorization)
    {
        //
    }

    public function reprintAuth(Request $request)
    {
        try {
            $token = Token::where('value', $request->get('auth'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'El código de autorización no coincide con ninguno registrado']);
            return redirect()->back();
        }

        $token->load('authorization');

        if (! empty($token->authorization)) {

            alert()->flash('Error', 'warning', ['text' =>'La clave ya fue utilizada']);
            return redirect()->back();
        }

        try {
            $credit = Credit::findOrFail($request->get('credit_id'));
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'No se encontro el credito']);
            return redirect()->back();
        }

        $credit->load('sale');

        $authorization = new Authorization;

        $authorization->value = 1;
        $authorization->type = 'auth_reprint: '.$request->get('type');
        $authorization->token()->associate($token);
        $authorization->sale()->associate($credit->sale);
        $authorization->save();

        if ($request->get('type') == 'contract') {
            session(['reprint-contract' => true]);
            return redirect()->route('credits.contract', $credit->id);
        } elseif ($request->get('type') == 'departure-order') {
            session(['reprint-departure-order' => true]);
            return redirect()->route('credits.departure.order', $credit->id);
        }
    }

    public function deleteCredit(Request $request)
    {
        try {
            $token = Token::where('value', $request->get('auth'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'El código de autorización no coincide con ninguno registrado']);
            return redirect()->back();
        }

        $token->load('authorization');

        if (! empty($token->authorization)) {

            alert()->flash('Error', 'warning', ['text' =>'La clave ya fue utilizada']);
            return redirect()->back();
        }

        try {
            $credit = Credit::findOrFail($request->get('credit_id'));
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'No se encontro el credito']);
            return redirect()->back();
        }

        $credit->load('sale');

        $authorization = new Authorization;

        $authorization->value = 1;
        $authorization->type = 'Baja';
        $authorization->token()->associate($token);
        $authorization->sale()->associate($credit->sale);
        $authorization->save();

        $opt = 'credits';
        $deleteCredit = new CreditController();
        $deleteCredit->unsubscribe($request->get('credit_id'),$request->get('observation'));
        alert()->flash('Completado', 'success', ['text' => 'Credito dado de baja con exito']);
        return redirect()->route('credits.index', ['opt' => $opt]);
    }

    public function returnPayment(Request $request)
    {
        try {
            $token = Token::where('value', $request->get('auth'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'El código de autorización no coincide con ninguno registrado']);
            return redirect()->back();
        }

        $token->load('authorization');

        if (! empty($token->authorization)) {

            alert()->flash('Error', 'warning', ['text' =>'La clave ya fue utilizada']);
            return redirect()->back();
        }

        try {
            $credit = Credit::findOrFail($request->get('credit_id'));
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'No se encontro el credito']);
            return redirect()->back();
        }

        $credit->load('sale');

        $authorization = new Authorization;

        $authorization->value = 1;
        $authorization->type = 'Baja';
        $authorization->token()->associate($token);
        $authorization->sale()->associate($credit->sale);
        $authorization->save();

        $deleteCredit = new CreditController();
        $request = $request->all();
        $opt = $deleteCredit->lastPays($request);
        if ($opt) {
            alert()->flash('Completado', 'success', ['text' => 'Devolucion realizada con exito']);
            return redirect()->back();
        }else{
            alert()->flash('Operacion no permitida!', 'warning', ['text' => 'No puede realizar la accion ya que el crédito se a dado de baja.']);
            return redirect()->back();
        }
        
    }

    public function deleteSale(Request $request)
    {
        try {
            $token = Token::where('value', $request->get('auth'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'El código de autorización no coincide con ninguno registrado']);
            return redirect()->back();
        }

        $token->load('authorization');

        if (! empty($token->authorization)) {

            alert()->flash('Error', 'warning', ['text' =>'La clave ya fue utilizada']);
            return redirect()->back();
        }

        try {
            $sale = Sale::findOrFail($request->sale_id);
        } catch (ModelNotFoundException $e) {
            alert()->flash('Error', 'warning', ['text' =>'No se encontro el la venta']);
            return redirect()->back();
        }

        $authorization = new Authorization;

        $authorization->value = 1;
        $authorization->type = 'Baja';
        $authorization->token()->associate($token);
        $authorization->sale()->associate($sale->id);
        $authorization->save();

        $deleteSale = new SaleController();
        $deleteSale->unsubscribe($request->sale_id,$request->observation);
        alert()->flash('Completado', 'success', ['text' => 'Venta dada de baja con exito']);
        return redirect()->route('credits.index', ['opt' => 'sales']);
    }
}
