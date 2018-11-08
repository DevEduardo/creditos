<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;

use Exception;

use App\Category;

class Category extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'slug'];


	public function setNameAttribute($value)
	{
		$this->attributes['name'] = strtoupper($value);
	}

	public function products()
	{
		return $this->belongsToMany(Product::class);
	}

	public function category_products ()
	{
		return $this->hasMany('App\CategoryProduct');
	}

	
	public static function saveData ($request)
	{
	
		try {
			$category = new self();
			$category->fill($request->all());
			$category->slug = str_slug($request->name);
			$category->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar categoria");
        }

        return $category;
	}

	public static function updateData ($request, $id)
	{
		try {
			$category = Category::findOrFail($id);
			$category->fill($request->all());
			$category->slug = str_slug($request->name);
			$category->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al actualizar los datos");
        }

        return $category;
	}

	public static function deleteData ()
	{

	}
}
