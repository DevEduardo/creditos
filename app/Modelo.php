<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;
use App\Http\Requests\StoreModel;
use App\Http\Requests\UpdateModel;
use Illuminate\Support\Facades\DB;

use Exception;

class Modelo extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $table = 'models';

	protected $fillable = ['name', 'slug', 'brand_id'];

	
	public function brand ()
	{
		return $this->belongsTo('App\Brand');
	}


	public function products ()
	{
		return $this->hasMany('App\Product');
	}



	public static function saveData ($request)
	{
		try {
			
		$model = new self();
		
		$model->fill($request->all());
		$model->slug = str_slug($request->name);
		$model->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar nuevo modelo");
        }

        return $model;
	}


	public static function updateData ($request, $id)
	{

		try {
            $model = Modelo::findOrFail($id);
        } catch (Exception $e) {
            throw_if(true, $e, "Error al editar modelo");
        }

		try {
			$model->fill($request->all());
			$model->slug = str_slug($request->name);
			$model->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar modelo");
        }

        return $model;
	}
}
