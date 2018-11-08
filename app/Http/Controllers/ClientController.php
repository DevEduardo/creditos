<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\StoreClient2;
use App\Http\Requests\UpdateClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\CollectionDataTable;

use App\Client;
use App\SaleDetail;
use App\Profile;
use App\ClientType;
use App\Enterprise;
use App\ClientEnterprise;
use App\State;

use Exception;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index')
        ->with(
            [
                'title' => 'Lista de clientes', 'clients' => $clients,
                'new' => route('clients.create')
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
        $type_clients = ClientType::orderBy('name', 'ASC')->pluck('name', 'id');
        $enterprises  = Enterprise::all();
        $states       = State::orderBy('name', 'ASC')->pluck('name', 'id');

        return view('clients.create')->with([
            'title'         =>  'Nuevo cliente',
            'type_clients'  =>  $type_clients,
            'enterprises'   =>  $enterprises,
            'states'        =>  $states
        ]);
    }

    public function validationForm(Request $request)
    {
        $v = Validator::make($request->all(), [
                'name'              => 'required',
                'dni'               => 'required|string|unique:clients',
                'client_type_id'    => 'required|numeric',
                'image_dni'         => 'required|mimes:jpeg,png',
                'image_service'     => 'required|mimes:jpeg,png',
                'profession'        => 'required|string',
                'email'             => 'required|string|email',
                'address'           => 'required|string', 
                'postal_code'       => 'required|string',
                'phone1'            => 'required',
                'desc_phone'        => 'required',
                'district'          => 'required',
                'between_street'    => 'required',
                'location'          => 'required'
        ], [
                'name.required'              => 'El nombre es requerido',
                'dni.required'               => 'El DNI es requerido',
                'dni.string'                 => 'El DNI debe ser string',
                'dni.unique'                 => 'El DNI ya existe',
                'client_type_id.required'    => 'El tipo de cliente es requerido',
                'client_type_id.numeric'     => 'El tipo de cliente debe ser numérico',
                'image_dni.required'         => 'La imagen del DNI es requerida',
                'image_dni.mimes'            => 'La imagen del DNI debe ser jpge ó png',
                'image_service.required'     => 'La imagen del serivicio es requerida',
                'image_service.mimes'        => 'La imagen del serivicio debe ser jpeg ó png',
                'profession.required'        => 'La profesión u ocupación es requerida',
                'profession.string'          => 'La profesión debe ser string',
                'email.required'             => 'El email es requerido',
                'email.string'               => 'El email debe ser string',
                'email.email'                => 'El email tiene un formato invalido',
                'address.required'           => 'la dirección es requerida',
                'address.string'             => 'la dirección debe ser string', 
                'postal_code.required'       => 'El código postal es requerido',
                'postal_code.string'         => 'El código postal debe ser string',
                'phone1.required'            => 'El teléfono es requerido',
                'desc_phone.required'        => 'Debe ingresar la descripción del telefono',
                'district.required'          => 'Ingrese el barrio',
                'between_street.required'    => 'Ingrese entre calles',
                'enterprise.required_if'     => 'Debe ingresar la informacion laboral o datos de la empresa.',
                'location.required'          => 'Debe ingresar la localidad'
        ]);

        if ($v->fails()) {
            return response()->json([
                $v->errors()
            ], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient2 $request)
    {   
        DB::beginTransaction();
        
        try {

            $client = Client::saveData($request);

        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El nuevo cliente ha sido registrado con éxito.']);

        return redirect()->route('clients.index');
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
            $client = Client::findOrFail($id);
            $enterprise = ClientEnterprise::where('client_id', $client->id)->first();
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        $client->load('profile');
        
        return view('clients.show')
        ->with(
            [
                'title' => 'Información de cliente',
                'client' => $client,
                'enterprise' => $enterprise,
                'new' => route('clients.create')
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
            
            $client = Client::findOrFail($id);
            $type_clients = ClientType::orderby('name', 'ASC')->pluck('name', 'id');
            $states = State::all()->pluck('name', 'id');
            $enterprises = Enterprise::all();

        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        };

        $client->load('client_type', 'profile');


        if ($client->client_type->code == '010') {
            $client->load('client_enterprise.enterprise.profile');
        }

        $vars = [
            'title'         =>      'Editar Información de cliente',
            'client'        =>      $client,
            'type_clients'  =>      $type_clients,
            'enterprises'   =>      $enterprises,
            'states'        =>      $states,
        ];
        
        return view('clients.edit')->with($vars);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClient $request, $id)
    {

        DB::beginTransaction();
        
        try {
            Client::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro del cliente ha sido editado éxito.']);

        return redirect()->route('clients.index');
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
            
            $client = Client::findOrFail($id);
            #$profile = Profile::deleteData($client->profile_id);
            $client->delete();

        } catch (Exception $e) {
            #throw_if(true, Exception::class, "Error al eliminar!");
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }
        
         return redirect()->route('clients.index');
    }

    public function get($param, Request $request)
    {

        try 
        {
            switch ($request->get('opt')) {
                case 'renovation':
                    $result = DB::table('clients')
                        ->where('name', 'LIKE', "%" . $param . "%")
                        ->orWhere('dni', 'LIKE', "%" . $param . "%")
                        ->join('sales', 'sales.client_id', '=', 'clients.id')
                        ->leftJoin('credits', 'credits.sale_id', '=', 'sales.id')
                        ->where([
                            ['sales.finished', true],
                            ['client_type_id', '<>', 3]
                        ])
                        ->whereNotIn('credits.type', ['sing', 'simple'])
                        ->select('clients.*')
                        ->distinct()
                        ->get();
                    break;

                case 'scooter':
                    $result = DB::table('clients')
                        ->where('applies_moto', 1)
                        ->where(function ($query) use ($param){
                            $query->orWhere('dni', 'LIKE', "%" . $param . "%")
                                ->orWhere('name', 'LIKE', "%" . $param . "%");
                        })
                        ->get();

                    break;

                case 'simple':
                    $result = DB::table('clients')
                        ->where(function ($query) use ($param){
                            $query->orWhere('dni', 'LIKE', "%" . $param . "%")
                                ->orWhere('name', 'LIKE', "%" . $param . "%");
                        })
                        ->get();

                    break;

                case 'sing':
                    $result = DB::table('clients')
                        ->where(function ($query) use ($param){
                            $query->orWhere('dni', 'LIKE', "%" . $param . "%")
                                ->orWhere('name', 'LIKE', "%" . $param . "%");
                        })
                        ->get();

                    break;
                case 'online':
                    $result = DB::table('clients')
                        ->where(function ($query) use ($param){
                            $query->orWhere('dni', 'LIKE', "%" . $param . "%")
                                ->orWhere('name', 'LIKE', "%" . $param . "%");
                        })
                        ->get();

                    break;
                case 'others':
                    $result = DB::table('clients')
                        ->where(function ($query) use ($param){
                            $query->orWhere('dni', 'LIKE', "%" . $param . "%")
                                ->orWhere('name', 'LIKE', "%" . $param . "%");
                        })
                        ->get();

                    break;

                default:
                    $result = DB::table('clients')
                        ->whereNotIn('client_type_id', [3, 4])
                        ->where(function ($query) use ($param){
                            $query->orWhere('dni', 'LIKE', "%" . $param . "%")
                                ->orWhere('name', 'LIKE', "%" . $param . "%");
                        })
                        ->get();
                    break;
            }
        } 
        catch (Exception $e) 
        {
            return response()->json([
                '_message' => 'Ocurrio un error',
                'error' => $e->getMessage()
            ]);
        }

        return response()->json($result);

    }

    public function salesDatatable(Client $client)
    {
        
        $sales = SaleDetail::GetClient($client->id);

        return (new CollectionDataTable($sales))
            ->editColumn('date', function($sale) {
                return  \Carbon\Carbon::parse($sale->date)->format('d-m-Y');
            })
            ->editColumn('id', function($sale) {
                return  $sale->creditID;
            })
            ->editColumn('total', function($sale) {
                return number_format($sale->total, 2, ',', '.');
            })
            ->editColumn('is_payed', function($sale) {

                if ($sale->is_payed == 1) {
                        return '<span class="label label-success">Pagado</span>';
                }

                if ($sale->is_payed == 0  && $sale->status) {
                        return '<span class="label label-danger">Dado de baja</span>';
                }

                if ($sale->is_payed == 0) {
                        return '<span class="label label-warning">Por pagar</span>';
                }

                
                
            })
            ->addColumn('action', function($sale) {
                

                return view('buttons-datatables.creditDatatables-simple')->with('sale', $sale);
            })
            ->addColumn('action', function($sale) {
                if ($sale->finished && isset($sale->creditID)) {
                    return '<a href="'.url('credits/'.$sale->creditID.'/#fees').'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver"> 
                        <i class="fa fa-eye"></i> 
                    </a>';
                }

                return view('buttons-datatables.creditDatatables-simple')->with('sale', $sale);
            })
            ->rawColumns(['action', 'is_payed', 'id'])
            ->toJson();
    }

}