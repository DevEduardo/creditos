<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    
    protected $fillable = ['category_id', 'product_id'];

    public function category ()
    {
    	return $this->belongsTo(Category::class);
    }


    public function product ()
    {
    	return $this->belongsTo(Product::class);
    }


    public static function saveData($categories, $product)
    {
    	try
    	{
    		foreach ($categories as $key => $category) {
				CategoryProduct::updateOrCreate(
					[
						'category_id' 	=> $category,
					 	'product_id' 	=> $product->id
					]
				);
			}
    	} catch (Exception $e){
    		trow_if(true, Exception::class, "Error al registrar las categorias del producto");
    	}
    }
}
