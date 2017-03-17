<?php

use Illuminate\Database\Seeder;

class MakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $make = array (
            array(
            	'makeId' => 'MAKE0001',
				'makeName' => 'Toyota',
				'makeIsActive' => 1
            ),
        );
        DB::table('vehicle_make')->insert($make);
    }
}
