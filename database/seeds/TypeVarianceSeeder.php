<?php

use Illuminate\Database\Seeder;

class TypeVarianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tv = array (
            array(
				'tvTypeId' => 'TYPE001',
				'tvVarianceId' => 'VAR0001',
				'tvIsActive' => 1,
            ),
            array(
				'tvTypeId' => 'TYPE002',
				'tvVarianceId' => 'VAR0001',
				'tvIsActive' => 1,
            ),
            array(
				'tvTypeId' => 'TYPE001',
				'tvVarianceId' => 'VAR0002',
				'tvIsActive' => 1,
            ),
            array(
				'tvTypeId' => 'TYPE002',
				'tvVarianceId' => 'VAR0002',
				'tvIsActive' => 1,
            ),
            array(
                'tvTypeId' => 'TYPE003',
                'tvVarianceId' => 'VAR0003',
                'tvIsActive' => 1,
            ),
            array(
                'tvTypeId' => 'TYPE003',
                'tvVarianceId' => 'VAR0004',
                'tvIsActive' => 1,
            ),
            array(
                'tvTypeId' => 'TYPE003',
                'tvVarianceId' => 'VAR0005',
                'tvIsActive' => 1,
            ),
            array(
                'tvTypeId' => 'TYPE003',
                'tvVarianceId' => 'VAR0006',
                'tvIsActive' => 1,
            ),
        );
        DB::table('type_variance')->insert($tv);
    }
}
