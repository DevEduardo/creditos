<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$list = 
    	[
    		[
	            'name' => 'Master',
	            'display_name' => 'Master',
	            'description' => 'Programadores'
        	],
        	[
	            'name' => 'Gerente',
	            'display_name' => 'Gerente',
	            'description' => 'Gerente del sistema'
        	],
        	[
	            'name' => 'Administrador',
	            'display_name' => 'Administrador',
	            'description' => 'Administrador del sistema'
        	],
        	[
	            'name' => 'Vendedor',
	            'display_name' => 'Vendedor',
	            'description' => 'Vendedores del sistema'
        	],
        	[
	            'name' => 'Despachador',
	            'display_name' => 'Despachador',
	            'description' => 'Despachador del Sistema'
        	]
    	];

    	foreach ($list as $key => $value) {
    		DB::table('roles')->insert($value);	
    	}
    }
}
