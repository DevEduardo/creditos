<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClientType;
use App\Http\Requests\UpdateClientType;
use Illuminate\Support\Facades\DB;

use Exception;

use App\Company;

class ClientType extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $fillable = [
		'code', 
		'name', 
		'slug', 
		'credit',
		'interest',
		'daily_interest',
		'surcharge', 
		'max_fees', 
		'company_id'
	];


	public function clients ()
	{
		return $this->hasMany(Client::class);
	}


	public static function saveData ($request)
	{
		$clientType = new self();
		
		/*
            Verificar si existe la compañia    
        */
        try {
            $company = Company::findOrFail($request->company_id);
        } catch (\Exception $e) {
            throw_if(true, Exception::class, "Compañia no existe!");
        }


		try {
			$clientType->fill($request->all());
			$clientType->slug = str_slug($request->name);
			$clientType->save();

        } catch (Exception $e) {
        	#dd($e);
            throw_if(true, Exception::class, "Error al registrar tipo de cliente");
        }

        return $clientType;
	}

	public static function updateData ($request, $id)
	{
		try {

			$clientType = ClientType::findOrFail($id);
			
			$clientType->fill($request->all());

			$clientType->interest = json_encode($request->get('interest'));

			$clientType->update();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar los datos");
        }

        return $clientType;
	}


	public static function deleteData ($id)
	{
		try {

			$clientType = ClientType::findOrFail($id);
			$profile->save();


        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar perfil");
        }

        return $profile;
	}
}
