<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClientType;
use App\Http\Requests\UpdateClientType;
use Illuminate\Support\Facades\DB;

use Exception;

use App\ClientType;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientTypes = ClientType::all();
        return view('client_types.index')
        ->with(
            [
                'title' => 'Lista Tipos de Clientes', 
                'clientTypes' => $clientTypes,
                #'new' => route('clientTypes.create')
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
        return view('client_types.create')->with(['title' => 'Nuevo Tipo de Cliente']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientType $request)
    {   

        DB::beginTransaction();
        
        try {
            
            ClientType::saveData($request);

        } catch (\Exception $e) {
            
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El nuevo tipo de cliente ha sido registrado con éxito.']);

        return redirect()->route('clientTypes.index');
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
            $clientType = ClientType::with('clients.profile')->findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        return view('client_types.show')
        ->with(
            [
                'title' => 'Información de Usuario', 'clientType' => $clientType,
                'new' => route('clientTypes.create')
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
        $clientType = ClientType::findOrFail($id);
       
        return view('client_types.edit')->with(['title' => 'Editar Información de Usuario', 'clientType' => $clientType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientType $request, $id)
    {
        DB::beginTransaction();
        
        try {
            ClientType::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('clientTypes.index');
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
            $clientType = ClientType::findOrFail($id);
            $clientType->delete();
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }

        return redirect()->route('clientTypes.index');
    }
}
