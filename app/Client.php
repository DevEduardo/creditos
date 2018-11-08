<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Http\Request;
use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;

use Exception;
use App\Company;

class Client extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	
	protected $fillable = [
        'name', 
        'dni', 
        'client_type_id',
		'image_dni', 
        'image_service', 
        'receipt_payment',
        'is_working', 
        'profession',
        'enterprise',
        'applies_moto'
    ];

	public function profile ()
	{
		return $this->belongsTo('App\Profile')->withDefault();
	}

	public function sales ()
	{
		return $this->hasMany('App\Sale');
	}

	public function client_type ()
	{
		return $this->belongsTo(ClientType::class);
	}

	public function client_enterprise ()
	{
		return $this->hasOne(ClientEnterprise::class);
	}

    /**
     * Si este campo va true tiene que pagar la primera cuota.
     * @return boolean true|false
     */
    public function getFirstFeeAttribute()
    {
        $this->load('sales.credit');

        $val = true;

        $this->sales->each(function($sale) use (&$val){
            if (! empty($sale->credit) && $sale->finished) {
                $val = false;
            }
        });

        return $val;
    }

    public function getPhone1Attribute()
    {
        $this->load('profile');

        $value = $this->profile->phone1;

        if (is_string($value) && (is_object(json_decode($value)) || is_array(json_decode($value)))) {
            return json_decode($value, true);
        } else {
            $telephone = [];

            $telephone[] = ['phone' => $value, 'description' => 'Teléfono'];
            if (! empty($this->profile->phone2)) {
                $telephone[] = ['phone' => $this->phone2, 'description' => 'Teléfono'];
            }

            return $telephone;
        }
    }

    public function getCreditLimitAttribute()
    {
        $otherCredits = \App\Credit::where('is_payed', false)
            ->join('sales', 'credits.sale_id', '=', 'sales.id')
            ->whereNotIn('sales.type', ['moto', 'simple', 'sing'])
            ->where('sales.client_id', $this->id)
            ->where('credits.status', null)
            ->select('credits.*')
            ->get();

        $valor = $this->client_type->credit - $otherCredits->sum('amount');

        if ($valor >= 0) {
            return '$ '.number_format($valor, 0, ',', '.').' de $ '.number_format($this->client_type->credit, 0, ',', '.');
        } else {
            return 'Excede: $ '.number_format(abs($valor), 0, ',', '.').' sobre $ '.number_format($this->client_type->credit, 0, ',', '.');
        }
    }

	public static function saveData ($request)
	{
		$client = new self();
        
        /*
            Guardar el Perfil de Cliente
         */

        try {

            //dd($request);
            
            /**
                Almacenamos el profile de client
            */

            $profile = Profile::saveProfileFromClient($request);

            $image_rp = $image_service = $image_dni = null;

            //Guardo Las Imagenes
            if ($request->has('image_dni')) {
                $image_dni = Image::saveImage($request->file('image_dni'), 'uploads/clients/');
            }

            if ($request->has('image_service')) {
                $image_service = Image::saveImage($request->file('image_service'), 'uploads/clients/');
            }
            
            if ($request->has('receipt_payment')) {
                $image_rp = Image::saveImage($request->file('receipt_payment'), 'uploads/clients/');
            }

            $client->fill($request->all());

            if ($request->get('client_type_id') == 3 || $request->has('applies_moto')) {
                $client->applies_moto = true;
            } elseif(! $request->has('applies_moto')) {
                $client->applies_moto = false;
            }

            //Asigno nombre de las imagenes a guardar
            $client->image_dni = $image_dni;
            $client->image_service = $image_service;
            if ($request->has('receipt_payment')) {
                $client->receipt_payment = $image_rp;
            }

            //if ($request->get('client_type_id') == 2) {
                $client->enterprise = json_encode($request->get('enterprise'));
            //}

            //Asocio el cliente al perfil
            $client->profile()->associate($profile);

            //dd($client);
            $client->save();

            //Si el Cliente es 010 
            /*if ($request->get('client_type_id') == 2) {
                
                if ($request->get('enterprise_id') != 'new') {
                    $enterprise = Enterprise::find($request->get('enterprise_id'));

                }else{
                    $enterprise = Enterprise::saveData($request);
                }

                //Guardo la asociacion de cliente y empresa a la que pertenece
                $clientEnterprise = new ClientEnterprise();
                $clientEnterprise->enterprise_id = $enterprise->id;
                $clientEnterprise->client_id = $client->id;
                $clientEnterprise->save();
            }*/
                
           

        } catch (Exception $e) {
            throw_if(true, Exception::class, $e->getMessage());
        }

    
        return $client;
	}

	public static function updateData ($request, $id)
    {

        /*
            Verificar si existe el cliente
        */
        try {
            
            $client = Client::findOrFail($id);

        } catch (\Exception $e) {
            throw_if(true, Exception::class, "Usuario no existe!");
        }
        
        $client->load('client_enterprise');
        
        /*
            Actualizar el Perfil del cliente
         */
        try {

            Profile::updateProfileFromClient($request, $client->profile_id);

            if (auth()->user()->hasRole('Administrador') || 
                auth()->user()->hasRole('Master') ||
                auth()->user()->can('admin-users') ||
                auth()->user()->can('administrator')
            ) {
                $client->fill($request->all());

                if (!empty($request->file('image_dni'))) {
                    $image_dni = Image::saveImage($request->file('image_dni'), 'uploads/clients/', $client->image_dni);

                    $client->image_dni = $image_dni;
                }

                if (!empty($request->file('image_service'))) {
                    $image_service = Image::saveImage($request->file('image_service'), 'uploads/clients/', $client->image_service);

                    $client->image_service = $image_service;
                }

                if ($request->has('receipt_payment')) {
                    $image_rp = Image::saveImage($request->file('receipt_payment'), 'uploads/clients/');

                    $client->receipt_payment = $image_rp;
                }

                $client->enterprise = json_encode($request->get('enterprise'));
            }

            if ($request->get('client_type_id') == 3 || $request->has('applies_moto')) {
                $client->applies_moto = true;
            } elseif (! $request->has('applies_moto')) {
                $client->applies_moto = false;
            }
            
            $client->save();

            // Actualizar cliente - empresa
            /*if ($request->get('client_type_id') == 2) {
                

                if ($request->get('enterprise_id') != 'new') {
                    //Si actualiza a empresa registrada
                    $enterprise = Enterprise::find($request->get('enterprise_id'));

                }else{
                    //Si actualiza a empresa nueva
                    $enterprise = Enterprise::saveData($request);
                }

                //Buscar en ClientEnterprise antiguo registro de cliente -  empresa                
                $clientEnterprise = ClientEnterprise::where('client_id', $client->id)->first();
                
                if(!empty($clientEnterprise)){

                    // Si existe el cliente pero en otra empresa se actualiza el id de la empresa en client_entrerprises
                    $clientEnterprise->update(                    [
                            'enterprise_id'     =>  $enterprise->id
                        ]
                    );

                }else{
                    //Crear Nuevo registro Cliente - Empresa, en client_enterprises
                    ClientEnterprise::create(                    [
                            'enterprise_id'     =>  $enterprise->id,
                            'client_id'         =>  $client->id
                        ]
                    );
                }
            }*/


            //Si el Cliente es 010 y pasa a 03
           if ($request->get('client_type_id') == 1 && !empty($client->client_enterprise)) {
                $client->client_enterprise()->dissociate();
                //$client_enterprise = ClientEnterprise::where('client_id', $client->id)->first();
                //$client_enterprise->delete();
            }
            

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar usuario");
        }
    
        return $client;
    }	
}