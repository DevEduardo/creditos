<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'company_id' => 1,
            'profile_id' => 2,
            'remember_token' => str_random(25)
        ]);

        DB::table('users')->insert([
            'name' => 'Vendedor',
            'email' => 'vendedor@example.com',
            'password' => bcrypt('123456'),
            'company_id' => 1,
            'profile_id' => 4,
            'remember_token' => str_random(25)
        ]);

        DB::table('users')->insert([
            'name' => 'Gerente',
            'email' => 'gerente@example.com',
            'password' => bcrypt('123456'),
            'company_id' => 1,
            'profile_id' => 4,
            'remember_token' => str_random(25)
        ]);
    }
}
