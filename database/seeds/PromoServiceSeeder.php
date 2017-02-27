<?php

use Illuminate\Database\Seeder;

class PromoServiceSeeder extends Seeder
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
            	'promoSId' => 'PROMO0001',
				'promoServiceId' => 'SERV0001',
				'promoSIsActive' => 1,
            ),
        );
        DB::table('promo_service')->insert($promos);
    }
}
