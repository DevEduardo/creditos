<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Store extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'slug', 'company_id', 'profile_id'];


	public function company ()
	{
		return $this->belongsTo(Company::class);
	}

	public function profile ()
	{
		return $this->belongsTo(Profile::class);
	}

	public function store_inventories ()
	{
		return $this->hasMany(StoreInventory::class);
	}


	public static function saveData ($request)
	{
		try {

		$store = new self();

		$store->slug = str_slug($request->name);
		$store->fill($request->all());
		$store->default = 0;

		if($request->has('default')) {
			Store::where('profile_id', $request->profile_id)->where('company_id', $request->company_id)->update(['default'=>0]);
			$store->default = 1;
		}

		$store->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar el almacen");
        }

        return $store;
	}


	public static function updateData ($request, $id)
	{

		try {

        $store = Store::findOrFail($id);

       	} catch (Exception $e) {
            alert()->flash($e->getMessage(), 'warning', ['text' => 'Error intenta nuevamente.']);
            return redirect()->back();
        }

		try {

		$store->fill($request->all());
		$store->slug = str_slug($request->name);

		$store->default = 0;

		if($request->has('default')) {
			Store::where('profile_id', $request->profile_id)->where('company_id', $request->company_id)->update(['default'=>0]);
			$store->default = 1;
		}

		$store->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al editar el almacen");
        }

        return $store;
	}

}
