<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(ProfilesTableSeeder::class);

        $this->call(CompaniesTableSeeder::class);

    	$this->call(ProvidersTableSeedeer::class);

        $this->call(PermissionSeeder::class);

    	$this->call(RolesTableSeeder::class);

        $this->call(UsersTableSeeder::class);

        $this->call(BrandsTableSeeder::class);

        $this->call(ModelTableSeeder::class);

        $this->call(ClientTypesTableSeeder::class);
        
        $this->call(UserRolesTableSeeder::class);

        $this->call(StoresTableSeedeer::class);

        $this->call(TaxesTableSeedeer::class);

        //$this->call(deliverySeed::class);
    }
}
