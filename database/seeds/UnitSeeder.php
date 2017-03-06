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
				'unitName' => 'pc',
				'unitDesc' => 'Piece',
				'unitIsActive' => 1,
            ),
            array(
            	'unitId' => 'UNIT002',
				'unitName' => 'pack',
				'unitDesc' => 'Pack',
				'unitIsActive' => 1,
            ),
        );
        DB::table('unit')->insert($unit);
    }
}
