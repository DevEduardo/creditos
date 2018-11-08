<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => 'Credit Company LTDA.',
            'slug' => 'creditcompanyltda@gmail.com',
            'profile_id' => 1
        ]);

        DB::table('company_infos')->insert([
            'advance' => 500,
            'interest' => 10.5,
            'company_id' => 1
        ]);
    }
}
