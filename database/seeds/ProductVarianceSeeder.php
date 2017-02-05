<?php

use Illuminate\Database\Seeder;

class ProductVarianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_variance = array (
            array(
                'pvProductId' => 'PROD0001',
				'pvVarianceId' => 'VAR0001',
				'pvDesc' => '',
				'pvCost' => 500.00,
				'pvIsActive' => 1,
            ),
            array(
                'pvProductId' => 'PROD0001',
				'pvVarianceId' => 'VAR0002',
				'pvDesc' => '',
				'pvCost' => 250.00,
				'pvIsActive' => 1,
            ),
        );
        DB::table('product_variance')->insert($product_variance);
    }
}
