<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxesTableSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->insert([
            'name' => 'IVA',
            'value' => 21.00,
        ]);

        DB::table('taxes')->insert([
            'name' => 'IVA',
            'value' => 10.50,
        ]);

        DB::table('taxes')->insert([
            'name' => 'IVA',
            'value' => 3.50,
        ]);
    }
}
