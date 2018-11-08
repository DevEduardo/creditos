<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile; //subir archivos
use App\Http\Requests\StoreUser; //request storeUser
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Profile;
use App\Role;
use App\Company;

use Exception;

class User extends Authenticatable
{

    use Notifiable;

    use SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }


    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email',  
        'company_id', 
        'profile_id',
        'auth_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function company ()
    {
        return $this->belongsTo(Company::class);
    }


    public function profile ()
    {
        return $this->belongsTo(Profile::class);
    }


    public function invoices ()
    {
        return $this->hasMany(Invoice::class);
    }

    public function sales ()
    {
        return $this->hasMany(Sale::class);
    }


    public function deliveries ()
    {
        return $this->hasMany(Delivery::class);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function setAuthCodeAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['auth_code'] = sha1($value);
        }
    }

    /*public function getAuthCodeAttribute()
    {
        return decrypt($this->attributes['auth_code']);
    }*/

    public static function saveData ($request)
    {

        $user = new self();
        
        
        /*
            Verificar si existe la compañia    
        */
        try {
            $company = Company::findOrFail($request->company_id);
        } catch (\Exception $e) {
            throw_if(true, Exception::class, "Compañia no existe!");

        }

        /*
            Guardar el Perfil de Usuario
         */

        try {
            
            $profile = Profile::saveProfileFromUser($request);
            $user->fill($request->all());
            $user->profile()->associate($profile);
            $user->password = bcrypt($request->password);
            $user->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar usuario");
        }

        /*
            Verificar si existe el Rol
         */

        try {
            $role = Role::findOrFail($request->role_id);
        } catch (\Exception $e) {
            throw_if(true, Exception::class, "Rol no existe!");
        }

        /*
            Asignar Rol a Usuario
         
        */

        try {
            DB::table('role_user')->insert([['user_id' => $user->id, 'role_id' => $role->id]]);
        }  catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al asignar rol a usuario");
        }
    
        return $user;
    }


    public static function updateData ($request, $id)
    {
        /*
            Verificar si existe el usuario
        */
        try {
            
            $user = User::findOrFail($id);
            #dd($user);

        } catch (\Exception $e) {
            throw_if(true, Exception::class, "Usuario no existe!");
        }
        
        /*
            Verificar si existe la compañia    
        */
        try {
            $company = Company::findOrFail  ($request->company_id);
        } catch (\Exception $e) {
            throw_if(true, Exception::class, "Compañia no existe!");
        }

        /*
            Verificar si existe el Rol
         */

        try {
            $role = Role::findOrFail($request->role_id);
        } catch (\Exception $e) {
            throw_if(true, Exception::class, "Rol no existe!");
        }


        /*
            Guardar el Perfil de Usuario
         */

        try {

            $destination = 'uploads/users/';
            Profile::updateProfileFromUser($request, $user->profile_id);

            $user->fill($request->all());

            #$user->profile()->associate($profile);
            if(! empty($request->get('password')) )
            {
                $user->password = bcrypt($request->password);
            }

            $user->save();


        } catch (\Illuminate\Database\QueryException $e) {
            //throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar usuario");
            dd($e);
        }

        /*
            Asignar Rol a Usuario
         
        */
        try {
            DB::table('role_user')->where('user_id', $user->id)->update(['role_id' => $role->id]);
        }  catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al asignar rol a usuario");
        }
    
        return $user;
    }


    public static function deleteData($id)
    {
        try {
            
            $user = User::findOrFail($id);

            if ($user->id === 1) {
                alert()->flash('No puedes eliminar al Master', 'warning', ['text' => 'Error intenta nuevamente.']);
                return redirect()->back();
            }else{
                $profile = Profile::deleteProfileFromUser($user->profile_id);
                $user->delete();
            }

        } catch (Exception $e) {
            #throw_if(true, Exception::class, "Error al eliminar!");
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
    }

}
