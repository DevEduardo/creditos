<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreModel;
use App\Http\Requests\UpdateModel;
use Illuminate\Support\Facades\DB;

use Exception;

use App\Modelo;
use App\Brand;

class ModelController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Modelo::all();
        return view('models.index')
        ->with(
            [
                'title' => 'Lista de Modelos', 'models' => $models,
                'new' => route('models.create')
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
    	$brands = Brand::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('models.create')->with(['title' => 'Nuevo Modelo', 'brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModel $request)
    {   
        #dd($request);

        DB::beginTransaction();
        
        try {
            
            Modelo::saveData($request);

        } catch (\Exception $e) {
            #dd($e);
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El modelo ha sido registrado con éxito.']);

        return redirect()->route('models.index');
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
            $model = Modelo::findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        return view('models.show')
        ->with(
            [
                'title' => 'Información del Modelo', 'model' => $model,
                'new' => route('models.create')
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
        $model = Modelo::findOrFail($id);
        $brands = Brand::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('models.edit')
        ->with(
            [
                'title' => 'Editar Información del modelo', 'model' => $model, 'brands' => $brands,
                'new' => route('models.create')
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
    public function update(UpdateModel $request, $id)
    {
        DB::beginTransaction();
        
        try {
            Modelo::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('models.index');
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
            $model = Modelo::findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }

        $model->delete();
        
        return redirect()->route('models.index');
    }
}
