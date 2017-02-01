<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = array (
            array(
            	'productId' => 'PROD0001',
                'productBrand' => 'Petron',
				'productName' => 'XCS Euro 4',
				'productTypeId' => 'TYPE002',
				'productDesc' => 'Premium Plus Grade',
				'productIsActive' => 1,
            ),
            array(
            	'productId' => 'PROD0002',
                'productBrand' => 'Petron',
				'productName' => 'Turbo Diesel',
				'productTypeId' => 'TYPE002',
				'productDesc' => '',
				'productIsActive' => 1,
            ),
        );
        DB::table('product')->insert($product);
    }
}
