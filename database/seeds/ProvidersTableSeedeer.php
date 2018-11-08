<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvidersTableSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('providers')->insert([
        	'name' => 'Samsung Company LTD',
        	'cuit' => '034576341234',
        	'is_active' => 1,
        	'profile_id' => 3,
        	'company_id' => 1
        ]);

        DB::table('providers')->insert([
        	'name' => 'LG Company LTD',
        	'cuit' => '034576341234',
        	'is_active' => 1,
        	'profile_id' => 4,
        	'company_id' => 1
        ]);
    }
}
