<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('models')->insert([
        	'name' => 'SPLIT2412',
        	'slug' => 'split2410',
        	'brand_id' => 1
        ]);

        DB::table('models')->insert([
            'name' => 'AUDIO1234',
            'slug' => 'audio1234',
            'brand_id' => 2
        ]);
    }
}
