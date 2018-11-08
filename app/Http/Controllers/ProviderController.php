<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreProvider;
use App\Http\Requests\UpdateProvider;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\CollectionDataTable;

use Exception;
use File;

use App\Provider;
use App\Profile;
use App\State;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::all();
        return view('providers.index')
        ->with(
            [
                'title' => 'Lista de Proveedores', 'providers' => $providers,
                'new' => route('providers.create')
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
        $states = State::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('providers.create')->with(
            [
                'title'     =>  'Nuevo Proveedor',
                'states'    =>  $states
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProvider $request)
    {   
        #dd($request);

        DB::beginTransaction();
        
        try {
            
            Provider::saveData($request);

        } catch (\Exception $e) {
            #dd($e);
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro se ha completado con éxito.']);

        return redirect()->route('providers.index');
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
            $provider = Provider::findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        return view('providers.show')
        ->with([
            'title' => 'Información del proveedor', 
            'provider' => $provider,
            'new' => route('providers.create')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $provider = Provider::findOrFail($id);
            $states = State::all();
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Proveedor no encontrado.']);
            return redirect()->back();
        }
       
        return view('providers.edit')
        ->with(
            [
                'title'     =>  'Editar Información del proveedor',
                'provider'  =>  $provider,
                'new'       =>  route('providers.create'),
                'states'    =>  $states
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
    public function update(UpdateProvider $request, $id)
    {
        #dd($request);
        
        DB::beginTransaction();
        
        try {
            Provider::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('providers.index');
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
            
            $provider = Provider::findOrFail($id);
            #Profile::deleteData($provider->profile_id); //Elimino el Perfil
            $provider->delete(); //Elimino el Proveedor

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        return redirect()->route('providers.index');
    }

    public function invoicesDatatable(Provider $provider)
    {
        $provider->load('invoices');

        return (new CollectionDatatable($provider->invoices))
            ->editColumn('date', function($invoice) {
                return $invoice->date->format('d-m-Y');
            })
            ->addColumn('action', function($invoice){
                return '';
            })
            ->toJson();
    }
}
