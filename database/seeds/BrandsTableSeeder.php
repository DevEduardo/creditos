<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
        	'name' => 'Samsung',
        	'slug' => 'samsung'
        ]);

        DB::table('brands')->insert([
            'name' => 'LG',
            'slug' => 'lg'
        ]);
    }
}