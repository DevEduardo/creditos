<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBrand;
use App\Http\Requests\UpdateBrand;

use Exception;

use App\Brand;

class Brand extends Model
{
    use SoftDeletes;
	
	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'image', 'slug'];


	public function products ()
	{
		return $this->hasMany('App\Product');
	}


	public function models ()
	{
		return $this->hasMany('App\Modelo');
	}


	public static function saveData ($request)
	{

		try {
			
		$brand = new self();
		
		$destination = 'uploads/brands/';
        $image = $request->file('image');
        $random = str_random(6);

        if (!empty($image)) {
            $filename = trim($random . $image->getClientOriginalName());
            $image->move($destination, $filename);
        }else{
            $filename = '';
        }
		
			$brand->fill($request->all());
			$brand->slug = str_slug($request->name);
			$brand->image = $filename;
			$brand->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar nueva marca");
        }

        return $brand;
	}


	public static function updateData ($request, $id)
	{

		try {
            $brand = Brand::findOrFail($id);
        } catch (Exception $e) {
            throw_if(true, $e, "Error al registrar nueva marca");
        }

		try {
		
		$destination = 'uploads/brands/';
        $image = $request->file('image');
        $random = str_random(6);

        if (!empty($image)) {
            $filename = trim($random . $image->getClientOriginalName());
            $image->move($destination, $filename);
        }else{
            $filename = $brand->image;
        }
		
			$brand->fill($request->all());
			$brand->slug = str_slug($request->name);
			$brand->image = $filename;
			$brand->save();

        } catch (\Illuminate\Database\QueryException $e) {
            throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar nueva marca");
        }

        return $brand;
	}


	public static function deleteData ($id)
	{

	}
}
