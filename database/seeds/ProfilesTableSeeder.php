<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert(
        	[
	            'image' => 'avatar.png',
	            'email' => 'company@admin.com',
                'location'   => 6698,
	            'address' => 'Argentina Centro',
	            'postal_code' => 6307,
	            'phone1' => '+584241510577',
	            'phone2' => '',
	            'webpage' => 'http://www.creditcompanyltda.com.ar'
    	    ]
    	);

    	DB::table('profiles')->insert(
    	    [
	            'image' => 'avatar.png',
	            'email' => 'admin@admin.com',
                'location'   => 6698,
                'address' => 'Argentina Centro',
                'postal_code' => 6307,
	            'phone1' => '+584241510577',
	            'phone2' => '',
	            'webpage' => 'http://www.creditcompanyltda.com.ar'
    	    ]
    	);

        DB::table('profiles')->insert(
            [
                'image' => 'avatar.png',
                'email' => 'ventas@samsung.com',
                'location'   => 6698,
                'address' => 'Argentina Centro',
                'postal_code' => '2301',
                'phone1' => '+584241510577',
                'phone2' => '',
                'webpage' => 'http://www.samsung.com.ar'
            ]
        );

        DB::table('profiles')->insert(
            [
                'image' => 'avatar.png',
                'email' => 'ventas@lg.com',
                'location'   => 6698,
                'address' => 'Argentina Centro',
                'postal_code' => '2301',
                'phone1' => '+584241510577',
                'phone2' => '',
                'webpage' => 'http://www.lg.com.ar'
            ]
        );
    }
}