<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class deliverySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('clients')->insert([
    		'name' => "Jhon", 
    		'dni' => "2132423532", 
    		'client_type_id' => 1,
    		'image_dni' => "2132343", 
    		'image_service' => "24325235", 
    		'is_working' => true, 
    		'profession' => "safsdfgdsg",
    		'profile_id' => 1
    	]);

    	DB::table('products')->insert([
    		'name' => 'Test Product', 
    		'code' => uniqid(), 
    		'reference' => uniqid(), 
    		'description' => "blablablablablabla", 
    		'specification' => "blablablablablabla", 
    		'price' => 5000, 
    		'color' => 'black', 
    		'original_price' => 5000, 
    		'stock_minimun' => 1, 
    		'brand_id' => 1, 
    		'model_id' => 1, 
    		'company_id' => 1, 
    		'slug' => 'test-product'
    	]);

    	DB::table('store_inventories')->insert([
    		'store_id' => 1,
    		'product_id' => 1,
    		'qty' => 50
    	]);

    	DB::table('store_inventories')->insert([
    		'store_id' => 2,
    		'product_id' => 1,
    		'qty' => 20
    	]);

    	DB::table('store_inventories')->insert([
    		'store_id' => 3,
    		'product_id' => 1,
    		'qty' => 10
    	]);

		DB::table('sales')->insert([
			'date' => date('Y-m-d'), 
			'company_id' => 1, 
			'client_id' => 1, 
			'user_id' => 1, 
			'tax' => 8.2, 
			'discount' => 8.2, 
			'total' => 8.2, 
			'subtotal' => 8.2,
			'observations' => "blablablablabla"
		]);

		DB::table('sale_details')->insert([
			'sale_id' => 1, 
			'product_id' => 1, 
			'price' => 1000, 
			'qty' => 10,  
			'subtotal' => 8.2
		]);

		DB::table('deliveries')->insert([
			'date' => date('Y-m-d'), 
			'observation' => "blablablabla", 
			'completed' => false, 
			'user_id' => 1, 
			'sale_id' => 1,
		]);
    }
}
