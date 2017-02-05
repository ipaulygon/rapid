<?php

use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
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
            	'promoId' => 'PROMO0001',
				'promoName' => 'Buy 1 Take 1 Mobil Techron',
				'promoDesc' => '',
				'promoStart' => '2017-02-4',
				'promoEnd' => '2017-02-28',
				'promoIsActive' => 1,
            )
        );
        DB::table('promo')->insert($promos);
    }
}
