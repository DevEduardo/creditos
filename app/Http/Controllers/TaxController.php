<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTax;
use App\Http\Requests\UpdateTax;
use Illuminate\Support\Facades\DB;

use Exception;


use App\Tax;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxes = Tax::all();
        
        return view('taxes.index')->with(
            [
                'title' => 'Lista de Impuestos',
                'taxes' => $taxes, 
                'new' => route('taxes.create')
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taxes.create')->with(['title' => 'Nuevo Impuesto']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTax $request)
    {
        DB::beginTransaction();
        
        try {
            
            Tax::saveData($request);

        } catch (\Exception $e) {
            #dd($e);
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El impuesto ha sido registrado con éxito.']);

        return redirect()->route('taxes.index');
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
            $tax = Tax::findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        return view('taxes.show')
        ->with(
           [
                'title' => 'Información de Impuestos',
                'tax' => $tax, 
                'new' => route('taxes.create')
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
            $tax = Tax::findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }
        
        return view('taxes.edit')
            ->with(
               [
                    'title' => 'Información de Impuestos',
                    'tax' => $tax, 
                    'new' => route('taxes.create')
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTax $request, $id)
    {
        DB::beginTransaction();
        
        try {
            Tax::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('taxes.index');
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
            
            $tax = Tax::findOrFail($id);
            $tax->delete();

            } catch (Exception $e) {
                alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
                return redirect()->back();
            }

            return redirect()->route('taxes.index');
    }
}
