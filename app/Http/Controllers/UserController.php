<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use App\Role;
use App\State;
use App\City;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index')
        ->with(
            [
                'title' => 'Lista de Usuarios',
                'users' => $users,
                'new' => route('users.create')
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
        $roles = Role::orderBy('id', 'ASC')->pluck('name' , 'id');
        $states = State::orderBy('id', 'ASC')->pluck('name' , 'id');

        return view('users.create')
        ->with(
            [
                'title'     =>  'Nuevo Usuario',
                'roles'     =>  $roles,
                'states'    =>  $states
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {   

        DB::beginTransaction();
        
        try {
            User::saveData($request);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El nuevo usuario ha sido registrado con éxito.']);

        return redirect()->route('users.index');
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
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }
        
        return view('users.show')
        ->with(
            [
                'title' => 'Información de Usuario',
                'user' => $user,
                'new' => route('users.create')
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
        $user = User::findOrFail($id);
        $user->profile;
        $roles = Role::orderBy('id', 'ASC')->pluck('name' , 'id');
        #$states = State::orderBy('id', 'ASC')->pluck('name' , 'id');
        $states = State::all();
        
        return view('users.edit')->with(
            [
                'title' => 'Editar Información de Usuario',
                'user'  => $user,
                'roles' => $roles,
                'states'    => $states
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {

        DB::beginTransaction();
        
        try {
            User::updateData($request,$id);
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }

        DB::commit();
        alert()->flash('Registro Exitoso!', 'success', ['text' => 'El registro del usuario ha sido editado con éxito.']);

        return redirect()->route('users.index');
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
            $user = User::deleteData($id);
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }
        
        
        return redirect()->route('users.index');
         
        
    }


    public function profile ()
    {
        try {
            $user = User::findOrFail(Auth::id());
        } catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back()->withInput();
        }
        
        return view('users.show')
        ->with(
            [
                'title' => 'Información de Usuario',
                'user' => $user,
                'new' => route('users.create')
            ]
        );
    }
}
