<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$interest = [];

    	for ($i=0; $i < 24; $i++) { 
    		$interest[] = 10;
    	}

        DB::table('client_types')->insert([
        	'code' => '03',
        	'name' => 'Cliente 03',
        	'slug' => 'cliente-03',
        	'credit' => '30000',
        	'max_fees' => '24',
        	'company_id' => 1,
            'surcharge' => 0,
            'interest' => json_encode(["22.8","23","37.1","46.4","55","58.4","70.1","80","86.3","96","105.7","114.8","119.96","125.36","131","136.30","142.44","148.89","155.54","162.54","169.86","177.50","185.49","193.84"]),
            'daily_interest' => 0.65
        ]);

        DB::table('client_types')->insert([
        	'code' => '010',
        	'name' => 'Cliente 010',
        	'slug' => 'cliente-010',
        	'credit' => '10000',
        	'max_fees' => '24',
        	'company_id' => 1,
            'surcharge' => 10,
            'interest' => json_encode($interest),
            'daily_interest' => 0.65
        ]);


        DB::table('client_types')->insert([
            'code' => '100',
            'name' => 'Cliente Motos',
            'slug' => 'cliente-motos',
            'credit' => '10000',
            'max_fees' => '24',
            'company_id' => 1,
            'surcharge' => 10,
            'interest' => json_encode(["10","20","30","40","50","60","70","80","90","100","110","120","130","140","150","160","170","180","190","200","210","220","230","240"]),
            'daily_interest' => 0.65
        ]);

        DB::table('client_types')->insert([
            'code' => '101',
            'name' => 'Venta Directa',
            'slug' => 'venta-directa',
            'credit' => '10000',
            'max_fees' => '24',
            'company_id' => 1,
            'surcharge' => 0,
            'interest' => json_encode(["0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0"]),
            'daily_interest' => 0.65
        ]);
    }
}
