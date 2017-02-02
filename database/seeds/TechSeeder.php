<?php

use Illuminate\Database\Seeder;

class TechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tech = array (
            array(
            	'techId' => 'TECH0001',
				'techFirst' => 'Paul Andrei',
				'techMiddle' => '',
				'techLast' => 'Cruz',
				'techStreet' => '521 D. Santiago St.',
				'techBrgy' => 'Brgy. Pedro Cruz',
				'techCity' => 'San Juan City',
				'techContact' => '09054090523',
				'techEmail' => 'paulandrei@ymail.com',
				'techPic' => 'steve1.jpg',
				'techIsActive' => 1,
            ),
        );
        DB::table('technician')->insert($tech);
    }
}
