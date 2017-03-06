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
				'pvCost' => 500.00,
                'pvThreshold' => 10,
				'pvIsActive' => 1,
            ),
            array(
                'pvProductId' => 'PROD0001',
				'pvVarianceId' => 'VAR0002',
				'pvCost' => 250.00,
                'pvThreshold' => 10,
				'pvIsActive' => 1,
            ),
            array(
                'pvProductId' => 'PROD0002',
                'pvVarianceId' => 'VAR0003',
                'pvCost' => 300.00,
                'pvThreshold' => 10,
                'pvIsActive' => 1,
            ),
            array(
                'pvProductId' => 'PROD0002',
                'pvVarianceId' => 'VAR0004',
                'pvCost' => 500.00,
                'pvThreshold' => 10,
                'pvIsActive' => 1,
            ),
            array(
                'pvProductId' => 'PROD0002',
                'pvVarianceId' => 'VAR0005',
                'pvCost' => 1025.87,
                'pvThreshold' => 10,
                'pvIsActive' => 1,
            ),
            array(
                'pvProductId' => 'PROD0002',
                'pvVarianceId' => 'VAR0006',
                'pvCost' => 3000.75,
                'pvThreshold' => 10,
                'pvIsActive' => 1,
            ),
        );
        DB::table('product_variance')->insert($product_variance);
    }
}
