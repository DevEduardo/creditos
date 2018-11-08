<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Http\Request;

use Exception;
use File;

use App\CategoryProduct;
use App\ImageProduct;
use Carbon\Carbon;

class Product extends Model
{

	use SoftDeletes;

	protected $dates = ['deleted_at', 'date_update_price'];


	protected $fillable = [
		'name', 
		'code', 
		'reference', 
		'description', 
		'specification', 
		'price', 
		'color', 
		'original_price', 
		'stock_minimun', 
		'company_id', 
		'slug',
		'date_update_price',
		'color_secondary',
		'color_tertiary',
		'brand',
		'model',
		'web',
		'observation',
		'height',
		'width',
		'depth',
	];

	public function setNameAttribute($value)
	{
		return $this->attributes['name'] = strtoupper($value);
	}

	public function setReferenceAttribute($value)
	{
		return $this->attributes['reference'] = strtoupper($value);
	}

	public function setModelAttribute($value)
	{
		return $this->attributes['model'] = strtoupper($value);
	}

	public function setBrandAttribute($value)
	{
		return $this->attributes['brand'] = strtoupper($value);
	}

	public function setColorAttribute($value)
	{
		return $this->attributes['color'] = strtoupper($value);
	}

	public function setColorSecondaryAttribute($value)
	{
		return $this->attributes['color_secondary'] = strtoupper($value);
	}

	public function setColorTertiaryAttribute($value)
	{
		return $this->attributes['color_tertiary'] = strtoupper($value);
	}

	/*public function brand ()
	{
		return $this->belongsTo(Brand::class);
	}

	public function model ()
	{
		return $this->belongsTo(Modelo::class);
	}*/

	public function company ()
	{
		return $this->belongsTo(Company::class);
	}

	public function category_products ()
	{
		return $this->hasMany(CategoryProduct::class);
	}

	public function image_product ()
	{
		return $this->hasMany(ImageProduct::class);
	}

	public function store_inventory ()
	{
		return $this->hasMany(StoreInventory::class);
	}

	public function store_inventories ()
	{
		return $this->hasMany(StoreInventory::class);
	}

	public function inventory()
	{
		return $this->hasOne(Inventory::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'category_products');
	}

	public function delivery_details()
	{
		return $this->hasMany(DeliveryDetail::class);
	}

	public function getStockAttribute()
	{
		$this->load('store_inventories');

		$stock = 0;

		$this->store_inventories->each(function ($inventory) use (&$stock) {
			$stock += $inventory->qty;
		});

		return $stock;
	}

	public function getStringWebAttribute()
	{
		if ($this->web) {
			return '<span class="label label-success">Disponible</span>';
		} else {
			return '<span class="label label-danger">No disponible</span>';
		}
	}

	public static function saveData ($request)
	{
		try {

		$product = new self();

		$product->fill($request->all());
		$product->date_update_price = Carbon::now();
		$product->slug = str_slug($request->name);
		$product->code = $request->reference;
		$product->save();

		$categories = $request->categories;

		if (!empty($categories)) {
			CategoryProduct::saveData($categories, $product);
		}

		$images = $request->file('image');

        if (!empty($images)) {
			ImageProduct::saveData($images, $product);
        }


        } catch (Exception $e) {
            throw_if(true, Exception::class, "Error al registrar el producto ".$e->getMessage());
        }

        return $product;
	}

	public static function updateData ($request, $product_id)
	{
		try {

			$product = Product::findOrFail($product_id);

			if (!empty($request->get('price')) && ($request->get('price') != $product->price)) 
			{
				$product->date_update_price = Carbon::now();
			}

			$product->fill($request->all());

			if (! $request->has('web')) {
				$product->web = false;
			}

			if (! $request->has('observation')) {
				$product->observation = false;
			}
			
			$product->update();

			$categories = $request->categories;

			if (!empty($categories)) {
				
				$product->categories()->detach();

				$product->categories()->attach($categories);

				//$product->save();
				//CategoryProduct::saveData($categories, $product);
			} else {
				$product->categories()->detach();
			}

			$images = $request->file('image');

	        if (!empty($images)) {
				ImageProduct::saveData($images,$product);
	        }

		} catch (\Illuminate\Database\QueryException $e) {
			dd($e->getMessage());
            //throw_if(true, \Illuminate\Database\QueryException::class, "Error al registrar el producto");
        }

        return $product;

	}


	public static function deleteData ($id)
	{

		try {
			$product = Product::findOrFail($id);

            $images = ImageProduct::where('product_id', $product->id)->get();

            if (count($images) > 0) {
            	foreach ($images as $key => $image) {
	            	File::delete($image->path . $image->name);
	                $image->delete();
	            }
            }

            $categories = CategoryProduct::where('product_id', $product->id)->get();

            if(count($categories) > 0){
            	foreach ($categories as $key => $category) {
	            	$category->delete();
	            }
            }

            $product->delete();

		} catch (Exception $e) {
            throw_if(true, Exception::class, "Error al eliminar el producto");
        }

        return $product;

	}

	public static function syncPriceRollback($product) {

		try {

			$product->update_price = 0;
			$product->next_price = 0.00;

			$product->save();

		} catch (\Exception $e) {
			throw_if(true, \Exception::class, "Producto no encontrado.");
		}

		return $product;

	}

	public static function syncPrice(Request $request)
	{
		try {

			$product = self::findOrFail($request->product_id);

			if($request->has('update_price')){

				$product->update_price = $request->update_price;
				$product->next_price = $request->sale_price;

				if($request->has('pvp') && isset($request->pvp) && $request->get('pvp') != 0)
				{
					$product->next_price = $request->pvp;
				}

			}

			$product->save();

		} catch (Exception $e) {

			throw_if(true, \Exception::class, "Producto no encontrado");

		}
	}
}
