<?php

use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discount = array (
            array(
            	'discountId' => 'DS001',
				'discountName' => 'Senior Citizen',
				'discountRate' => 20,
				'discountIsActive' => 1,
            )
        );
        DB::table('discount')->insert($discount);
    }
}
