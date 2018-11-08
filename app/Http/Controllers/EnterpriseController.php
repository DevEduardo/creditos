<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreEnterprise;
use App\Http\Requests\UpdateEnterprise;
use Illuminate\Support\Facades\DB;

use Exception;
use File;

use App\Enterprise;
use App\Profile;
use App\State;

class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enterprises = Enterprise::all();
        return view('enterprises.index')
        ->with(
            [
                'title' => 'Lista de Empresas', 
                'enterprises' => $enterprises,
                'new' => route('enterprises.create')
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

        return view('enterprises.create')->with(
            [
                'title'     => 'Nueva Empresa',
                'states'    =>  $states
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnterprise $request)
    {   
        #dd($request);

        DB::beginTransaction();
        
        try {
            
            Enterprise::saveData($request);

        } catch (\Exception $e) {
            #dd($e);
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro se ha completado con éxito.']);

        return redirect()->route('enterprises.index');
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
            $enterprise = Enterprise::findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        return view('enterprises.show')
        ->with(
            [
                'title' => 'Información de la empresa', 'enterprise' => $enterprise,
                'new' => route('enterprises.create')
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
        try {
            $enterprise = Enterprise::findOrFail($id);
            $states = State::all();
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Empresa no encontrado.']);
            return redirect()->back();
        }
       
        return view('enterprises.edit')
        ->with(
            [
                'title'         =>  'Editar Información del empresa',
                'enterprise'    =>  $enterprise,
                'new'           =>  route('enterprises.create'),
                'states'        =>  $states
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
    public function update(UpdateEnterprise $request, $id)
    {
        
        DB::beginTransaction();
        
        try {
            Enterprise::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('enterprises.index');
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
            Enterprise::deleteData($id);

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        return redirect()->route('enterprises.index');
    }
}
