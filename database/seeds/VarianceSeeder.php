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
            array(
                'varianceId' => 'VAR0002',
                'varianceSize' => '200 ml',
                'varianceDesc' => '',
                'varianceUnitId' => 'UNIT001',
                'varianceIsActive' => 1,
            ),
            array(
                'varianceId' => 'VAR0003',
                'varianceSize' => '3PK630',
                'varianceDesc' => '',
                'varianceUnitId' => 'UNIT001',
                'varianceIsActive' => 1,
            ),
            array(
                'varianceId' => 'VAR0004',
                'varianceSize' => '3PK645',
                'varianceDesc' => '',
                'varianceUnitId' => 'UNIT001',
                'varianceIsActive' => 1,
            ),
            array(
                'varianceId' => 'VAR0005',
                'varianceSize' => '3PK675',
                'varianceDesc' => '',
                'varianceUnitId' => 'UNIT001',
                'varianceIsActive' => 1,
            ),
            array(
                'varianceId' => 'VAR0006',
                'varianceSize' => '3PK750',
                'varianceDesc' => '',
                'varianceUnitId' => 'UNIT001',
                'varianceIsActive' => 1,
            ),
        );
        DB::table('variance')->insert($variance);
    }
}
