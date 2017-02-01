<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = array (
            array(
            	'unitId' => 'UNIT001',
				'unitName' => 'Piece',
				'unitDesc' => '',
				'unitIsActive' => 1,
            ),
            array(
            	'unitId' => 'UNIT002',
				'unitName' => 'Pack',
				'unitDesc' => '',
				'unitIsActive' => 1,
            ),
        );
        DB::table('unit')->insert($unit);
    }
}
