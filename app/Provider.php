<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;

use Exception;

use App\Provider;
use App\Profile;

class Provider extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'cuit', 'is_active', 'profile_id', 'company_id'];


	public function profile ()
	{
		return $this->belongsTo(Profile::class);
	}

	public function company ()
	{
		return $this->belongsTo(Company::class);
	}


	public function invoices ()
	{
		return $this->hasMany(Invoice::class);
	}



	public static function saveData ($request)
	{

		try {
			
			$provider = new self();
			
			$destination = 'uploads/providers/';
			$profile = Profile::saveData($request, $destination);
			
			$provider->fill($request->all());
            $provider->profile()->associate($profile);
			$provider->save();

        } catch (\Illuminate\Database\QueryException $e) {

            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar");

        } catch (\Exception $e) {
            
            throw_if(true, \Exception::class, "Error al registrar");

        }

        return $provider;
	}


	public static function updateData ($request, $id)
	{

		try {
            $provider = Provider::findOrFail($id);
        } catch (Exception $e) {
            throw_if(true, Exception::class, "Proveedor no encontrado");
        }

		try {
			
			$destination = 'uploads/providers/';

			Profile::updateData($request, $provider->profile_id, $destination);
			
			$provider->fill($request->all());
			$provider->save();
			


        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar nueva marca");
        }

        return $provider;
	}

}
