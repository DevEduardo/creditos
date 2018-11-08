<?php

namespace App;

use App\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;

use File;

use Exception;

class Profile extends Model
{
    use SoftDeletes;
    
	protected $fillable = [
		'image', 
		'email', 
		'address', 
		'location', 
		'postal_code', 
		'phone1', 
		'webpage',
		'add_info',
		'district',
		'between_street',
		'coordinates'
	];

	
	public function user ()
	{
		return $this->hasOne(User::class);
	}


	public function company ()
	{
		return $this->hasOne(Company::class);
	}


	public function provider ()
	{
		return $this->hasOne(Provider::class);
	}

	public function client ()
	{
		return $this->hasOne(Client::class);
	}


	public function enterprise ()
	{
		return $this->hasOne(Enterprise::class);
	}


	public function state ()
	{
		return $this->belongsTo(State::class);
	}


	public function city ()
	{
		return $this->belongsTo(City::class);
	}


	/*
		Guardar datos de perfil
	*/

	public static function saveData ($request, $destination = null)
	{

		try {

			$profile = new self();
				
				$filename = 'avatar.png';

				if ($request->has('image')) {
						$image 		= $request->file('image');

			        if (!empty($image)) {
			        	$filename 		= Image::saveImage($image, $destination);
			        }
				}

			/*$telephones = [
				'phone' => $request->get('phone1')[$i], 
				'description' => $request->get('desc_phone')[$i]
			];*/
				
	        $profile->fill($request->all());
			$profile->phone2 	= $request->get('phone2');
			$profile->image 	= $filename;
			$profile->save();
			
        } catch (Exception $e) {
        	#dd($e);
            throw_if(true, Exception::class, "Error al registrar perfil");
        }

        return $profile;
	}

	public static function updateData ($request, $profile_id, $destination = null)
	{
		try {
			$profile = Profile::findOrFail($profile_id);
		} catch (\Exception $e) {
        	throw_if(true, Exception::class, "Error, el perfil no existe!");
        }

		try {
			$filename   = $profile->image;
			$image 		= $request->file('image');
			
	        if (!empty($image)) {
	        	$imageToDelete 	= $profile->image;
	        	$filename 		= Image::saveImage($image, $destination, $imageToDelete);
	        }
	      
	        $profile->fill($request->all());
			$profile->phone2 	= $request->get('phone2');
	        $profile->image 	= $filename;
			$profile->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar perfil");
        } catch (\Exception $e) {
        	throw_if(true, Exception::class, "Error al actualizar perfil");
        }

        return $profile;
	}

	public static function deleteData ($id)
	{

		try {
			$profile = Profile::findOrFail($id);
			File::delete('uploads/providers/' . $profile->image); 
			$profile->delete();
		}  catch (\Exception $e) {
            throw_if(true, Exception::class, "No existe el perfil!");
        }

        return $profile;
    }




	// Crear Profile de Enterprise
	public static function saveProfileFromEnterprise ($request)
	{	
		try {
			$profile = new self();
			$profile->fill($request);

			$profile->phone2 	= $request['phone2'];
			$profile->save();
			
        } catch (Exception $e) {
            throw_if(true, Exception::class, "Error al registrar perfil");
        }

        return $profile;
	}

	// Actualizar Profile de Enterprise
	public static function updateProfileFromEnterprise ($request, $profile_id)
	{
		try {
			$profile = Profile::findOrFail($profile_id);
		} catch (\Exception $e) {
        	throw_if(true, Exception::class, "Error, el perfil no existe!");
        }

		try {
	        $profile->fill($request->all());
			$profile->phone2 	= $request->phone2;
			$profile->save();

        } catch (\Exception $e) {
        	throw_if(true, Exception::class, "Error al actualizar perfil");
        }

        return $profile;
	}


	public static function deleteProfileFromEnterprise ($id)
	{

		try {
			
			$profile = Profile::findOrFail($id);
			$profile->delete();

		}  catch (\Exception $e) {
            throw_if(true, Exception::class, "No existe el perfil!");
        }

        	return $profile;
    }


	/*
			*** User Profile ***
	*/

	// Crear Profile de User
	public static function saveProfileFromUser ($request)
	{

		try {

			$profile = new self();
				
				$filename = 'avatar.png';
				
				if ($request->has('image')) {
					$image 		= $request->file('image');

			        if (!empty($image)) {
			        	$destination 	= 'uploads/users/';
			        	$filename 		= Image::saveImage($image, $destination);
			        }
				}
				
	        $profile->fill($request->all());
			$profile->phone2 	= $request->phone2;
			$profile->image 	= $filename;
			$profile->save();
			
        } catch (Exception $e) {

            throw_if(true, Exception::class, "Error al registrar perfil del usuario");
        }

        return $profile;
	}

	//Actualizar Profile de User
	public static function updateProfileFromUser ($request, $profile_id)
	{
		try {
			$profile = Profile::findOrFail($profile_id);
		} catch (\Exception $e) {
        	throw_if(true, Exception::class, "Error, el perfil no existe!");
        }

		try {
			$image = $request->file('image');
			$filename   = $profile->image;

	        if (!empty($image)) {
	        	$imageToDelete 	= $profile->image;
	        	$destination = 'uploads/users/';
	        	$filename 	= Image::saveImage($image, $destination, $imageToDelete);
	        }
	        
	        $profile->fill($request->all());
	        #dd($profile);
			$profile->phone2 	= $request->phone2;
	        $profile->image 	= $filename;
			$profile->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar perfil");
        } catch (\Exception $e) {
        	throw_if(true, Exception::class, "Error al actualizar perfil");
        }

        return $profile;
	}

	//Eliminar Profile de User
	public static function deleteProfileFromUser ($id)
	{

		try {
			
			$profile = Profile::findOrFail($id);

			$destination = 'uploads/users/';
			Image::deleteImage($profile->image, $destination);	
			if (!empty($profile->image)) {
				
			}
			
			$profile->delete();

		}  catch (\Exception $e) {
            throw_if(true, Exception::class, "No existe el perfil!");
        }

        	return $profile;
    }




	// Actualizar Profile de Company
	public static function updateProfileFromCompany ($request, $profile_id)
	{

		try {
			$profile = Profile::findOrFail($profile_id);

			$filename   = $profile->image;
			$image 		= $request->file('image');
			$destination 	= 'uploads/companies/';

	        if (!empty($image)) {
	        	$imageToDelete 	= $profile->image;
	        	$filename 		= Image::saveImage($image, $destination, $imageToDelete);
	        }

	        $profile->fill($request->get('profile'));
			$profile->phone2 	= $request->profile['phone2'];
	        $profile->image 	= $filename;
			$profile->save();
			 


        } catch (\Exception $e) {
        	dd($e);
        	throw_if(true, Exception::class, "Error al actualizar perfil");
        }
    }


    // Crear Profile de Client
	public static function saveProfileFromClient ($request)
	{

		try {

			$profile = new self();
				
	        $profile->fill($request->all());

	        $telephones = [];

	        for ($i=0; $i < count($request->get('phone1')); $i++) { 
	        	$telephones[] = [
	        		'phone' => $request->get('phone1')[$i], 
	        		'description' => $request->get('desc_phone')[$i]
	        	];
	        }

			$profile->phone1 	= json_encode($telephones);
			$profile->add_info = json_encode([
				'prev_address' => $request->get('prev_address')
			]);

			$profile->save();
			
        } catch (Exception $e) {
        	#dd($e);
            throw_if(true, Exception::class, "Error al registrar perfil del cliente");
        }

        return $profile;
	}



    public static function updateProfileFromClient ($request, $profile_id)
	{

		try {
			$profile = Profile::findOrFail($profile_id);
		} catch (\Exception $e) {
        	throw_if(true, Exception::class, "Error, el perfil no existe!");
        }

		try {
	        $profile->fill($request->all());

            $telephones = [];

            for ($i=0; $i < count($request->get('phone1')); $i++) { 
            	$telephones[] = [
            		'phone' => $request->get('phone1')[$i], 
            		'description' => $request->get('desc_phone')[$i]
            	];
            }

    		$profile->phone1 	= json_encode($telephones);
    		$profile->add_info = json_encode([
    			'prev_address' => $request->get('prev_address')
    		]);

			$profile->save();


        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar perfil");
        } catch (\Exception $e) {
        	dd($e);
        	throw_if(true, Exception::class, "Error al actualizar perfil");
        }

        return $profile;
	}
}
