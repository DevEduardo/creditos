<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoresTableSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
        	'name' => 'Vitrina',
        	'slug' => 'vitrina',
        	'default'=>1,
        	'profile_id'=>1,
        	'company_id'=>1
        ]);

        DB::table('stores')->insert([
        	'name' => 'Principal',
        	'slug' => 'principal',
        	'default'=>0,
        	'profile_id'=>1,
        	'company_id'=>1
        ]);

        DB::table('stores')->insert([
        	'name' => 'Secundario',
        	'slug' => 'secundario',
        	'default'=>0,
        	'profile_id'=>1,
        	'company_id'=>1
        ]);

        DB::table('stores')->insert([
        	'name' => 'Alterno',
        	'slug' => 'alterno',
        	'default'=>0,
        	'profile_id'=>1,
        	'company_id'=>1
        ]);
    }
}
