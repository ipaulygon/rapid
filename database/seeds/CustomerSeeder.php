<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = array (
            array(
                'customerId' => 'CUST0001',
                'customerFirst' => 'Alexander',
                'customerMiddle' => '',
                'customerLast' => 'Leonor',
                'customerAddress' => '521 D. Santiago St., San Juan City',
                'customerEmail' => '',
                'customerContact' => '09279679229',
                'customerIsActive' => 1
            ),
        );
        DB::table('customer')->insert($customer);
    }
}
