<?php

use Illuminate\Database\Seeder;

class VarianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variance = array (
            array(
            	'varianceId' => 'VAR0001',
				'varianceSize' => '500 ml',
				'varianceDesc' => '',
				'varianceUnitId' => 'UNIT001',
				'varianceIsActive' => 1,
            ),
        );
        DB::table('variance')->insert($variance);
    }
}
