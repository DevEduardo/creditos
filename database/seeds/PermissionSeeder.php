<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
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
	            'name' => 'admin-users',
	            'display_name' => 'Administrar Usuarios',
	            'description' => 'Puede crear, listar, ver, editar y eliminar usuarios'
        	],
        	[
	            'name' => 'admin-enterprise',
	            'display_name' => 'Administrar Empresa',
	            'description' => 'Puede ver y editar la información de la empresa'
        	],
        	[
	            'name' => 'admin-stores',
	            'display_name' => 'Administrar Almacenes',
	            'description' => 'Puede crear, listar, ver, editar y eliminar Almacenes'
        	],
        	[
	            'name' => 'admin-providers',
	            'display_name' => 'Administrar Proveedores',
	            'description' => 'Puede crear, listar, ver, editar y eliminar Almacenes'
        	],
        	[
	            'name' => 'admin-clients',
	            'display_name' => 'Administrar Clientes',
	            'description' => 'Puede manipular el modulo de clientes'
        	],
        	[
	            'name' => 'admin-products',
	            'display_name' => 'Administrar Productos',
	            'description' => 'Puede manipular el modulo de productos'
        	],
        	[
	            'name' => 'admin-inventory',
	            'display_name' => 'Administrar Inventario',
	            'description' => 'Puede manipular el modulo de inventario'
        	],
        	[
	            'name' => 'admin-sales',
	            'display_name' => 'Administrar Ventas',
	            'description' => 'Puede manipular el modulo de ventas'
        	],
        	[
	            'name' => 'admin-deliveries',
	            'display_name' => 'Administrar Despachos',
	            'description' => 'Puede manipular el modulo de despachos'
        	],
        	[
	            'name' => 'admin-credits',
	            'display_name' => 'Administrar Creditos',
	            'description' => 'Puede manipular el modulo de creditos'
        	],
        	[
	            'name' => 'admin-roles',
	            'display_name' => 'Administrar Permisologia',
	            'description' => 'Puede manipular el modulo de permisologia'
        	],
        	[
	            'name' => 'administrator',
	            'display_name' => 'Administrador',
	            'description' => 'Puede administrar todo el sistema'
        	],
    	];

    	foreach ($list as $key => $value) {
    		DB::table('permissions')->insert($value);	
    	}
    }
}
