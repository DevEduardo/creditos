<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    
	protected $fillable = ['name', 'path', 'size', 'product_id'];
    
	protected $table = 'image_products';

    public function product()
    {
    	return $this->belongsTo(Products::class);
    }


    public static function saveData ($images, $product)
    {
    	try {
	    	$destination = 'uploads/products/'.$product->id;
				
	        	foreach ($images as $key => $image) {
	        		$filename = trim(str_random(6).$image->getClientOriginalName());
	        		$image->move($destination, $filename);

	        		ImageProduct::create(
	        			[
	        				'name'			=>	$filename,
	        				'path'			=>	$destination,
	        				'size'			=>	'4234',
	        				'product_id'	=>	$product->id
	        			]
	        		);
	        	}

        } catch (Exception $e){
    		trow_if(true, Exception::class, "Error al registrar las categorias del producto");
    	}

    }
}
