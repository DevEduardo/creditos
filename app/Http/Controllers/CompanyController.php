<?php

namespace App\Http\Controllers;

use App\Banks;
use App\Image;
use App\State;
use Exception;
use App\Company;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;

class CompanyController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        $banks   = Banks::all();
        $company->profile;
        #dd($company);
        return view('companies.show')->with(['title' => 'Información de la Empresa', 'company' => $company, 'banks' => $banks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $company = Company::findOrFail($id);
        $banks   = Banks::all();
        $states  = State::all();
       
        return view('companies.edit')
        ->with(
            [
                'title'     =>  'Editar Información de la empresa',
                'company'   =>  $company,
                'states'    =>  $states,
                'banks'    =>  $banks
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
    public function update(UpdateCompany $request, $id)
    {
        

        $company = Company::findOrFail($id);
        $company->fill($request->all());
        $company->save();

        $profile = Profile::findOrFail($company->profile_id);

        if (isset($request->profile['image'])) {
            $image = $request->profile['image'];
            $random     = str_random(6);
            $filename   = trim($random . $image->getClientOriginalName());
        }else{
            $filename = 'avatar.png';
        }
        

        if (!empty($image)) {
            Image::deleteImage($profile->image, 'uploads/companies/');
            $filename = Image::saveImage($image, 'uploads/companies/');
        }else{
            
        }

        $profile->fill($request->all());
        $profile->phone2    = $request->phone2;
        $profile->image     = $filename;
        $profile->save();
        $banks = Banks::where('companies_id', 1)->get();
        foreach ($banks as $key => $bank) {
            $bank = Banks::find($bank->id);
            $bank->bank = $request->bank[$key];
            $bank->cbu = $request->cbu[$key];
            $bank->number = $request->number[$key];
            $bank->alias = $request->alias[$key];
            $bank->save();
        }
        DB::beginTransaction();
        
        try {
            Company::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro ha sido editado con éxito.']);

        return redirect()->route('companies.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
