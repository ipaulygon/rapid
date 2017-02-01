<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = array (
            array(
            	'serviceId' => 'SERV0001',
				'serviceName' => 'Change Oil',
				'serviceDesc' => '',
				'serviceCategoryId' => 'SC001',
				'servicePrice' => 500.00,
				'serviceIsActive' => 1,
            )
        );
        DB::table('service')->insert($service);
    }
}
