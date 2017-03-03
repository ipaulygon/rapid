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
                'productBrandId' => 'BRAND0002',
				'productName' => 'Techron',
				'productTypeId' => 'TYPE002',
				'productDesc' => '',
				'productIsActive' => 1,
            ),
            array(
                'productId' => 'PROD0002',
                'productBrandId' => 'BRAND0003',
                'productName' => 'Fanbelt',
                'productTypeId' => 'TYPE003',
                'productDesc' => '',
                'productIsActive' => 1,
            ),
        );
        DB::table('product')->insert($product);
    }
}
