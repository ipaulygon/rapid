<?php

use Illuminate\Database\Seeder;

class PromoProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promos = array (
            array(
            	'promoPId' => 'PROMO0001',
				'promoProductId' => 1,
				'promoPQty' => 1,
                'promoPIsFree' => 0,
				'promoPIsActive' => 1,
            ),
            array(
                'promoPId' => 'PROMO0001',
                'promoProductId' => 2,
                'promoPQty' => 1,
                'promoPIsFree' => 1,
                'promoPIsActive' => 1,
            ),
        );
        DB::table('promo_product')->insert($promos);
    }
}
