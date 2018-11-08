<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;

class Enterprise extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'cuit', 'profile_id'];


	public function profile ()
	{
		return $this->belongsTo(Profile::class);
	}


	public function client_enterprise ()
	{
		return $this->hasOne(ClientEnterprise::class);
	}


	public static function saveData ($request)
	{
		
		try {
			
			$enterprise = new self();
			
			#dd($request);

			if ($request->has('enterprise')) {
				$enterprise->fill($request->get('enterprise'));
				$profile = Profile::saveProfileFromEnterprise($request->get('enterprise'));
			}else{
				$profile = Profile::saveProfileFromEnterprise($request->all());
				$enterprise->fill($request->all());
			}

            $enterprise->profile()->associate($profile);
			$enterprise->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar");

        } catch (\Exception $e) {
            throw_if(true, \Exception::class, "Error al registrar");
        }

        return $enterprise;
	}

	public static function updateData ($request, $id)
	{

		try {
            $enterprise = Enterprise::findOrFail($id);
        } catch (Exception $e) {
            throw_if(true, Exception::class, "Empresa no encontrada");
        }


		try {
			
			//$destination = 'uploads/enterprises/';

			$update = Profile::updateProfileFromEnterprise($request, $enterprise->profile_id);
			//dd($update);
			
			$enterprise->fill($request->all());
			//asociar
			$enterprise->save();


        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar nueva marca");
        }

        return $enterprise;
	}

	public static function deleteData ($id)
	{
		try{
		
			$enterprise = Enterprise::findOrFail($id);
	        Profile::deleteProfileFromEnterprise($enterprise->profile_id);
	        $enterprise->delete();
		}
			catch (\Exception $e) {
            throw_if(true, Exception::class, "No existe el perfil!");
        }
    }
		

		
	
}
