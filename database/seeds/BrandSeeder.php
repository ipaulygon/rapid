<?php

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = array (
            array(
            	'brandId' => 'BRAND0001',
				'brandName' => 'Caltex',
				'brandDesc' => '',
				'brandIsActive' => 1,
            ),
            array(
            	'brandId' => 'BRAND0002',
				'brandName' => 'Mobil',
				'brandDesc' => '',
				'brandIsActive' => 1,
            ),
            array(
                'brandId' => 'BRAND0003',
                'brandName' => 'Bando',
                'brandDesc' => '',
                'brandIsActive' => 1,
            ),
        );
        DB::table('brand')->insert($brand);
    }
}
