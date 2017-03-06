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
				'serviceName' => 'Change Oil and Oil Filter',
				'serviceDesc' => '',
				'serviceCategoryId' => 'SC001',
				'servicePrice' => 500.00,
                'serviceSize' => 1,
				'serviceIsActive' => 1,
            ),
            array(
                'serviceId' => 'SERV0002',
                'serviceName' => 'Change Oil, Oil Filter and Spark Plugs (4pcs)',
                'serviceDesc' => '',
                'serviceCategoryId' => 'SC001',
                'servicePrice' => 300.25,
                'serviceSize' => 1,
                'serviceIsActive' => 1,
            ),
            array(
            	'serviceId' => 'SERV0003',
				'serviceName' => 'Change Oil and Oil Filter',
				'serviceDesc' => '',
				'serviceCategoryId' => 'SC001',
				'servicePrice' => 1000.00,
                'serviceSize' => 2,
				'serviceIsActive' => 1,
            ),
            array(
                'serviceId' => 'SERV0004',
                'serviceName' => 'Change Oil, Oil Filter and Spark Plugs (4pcs)',
                'serviceDesc' => '',
                'serviceCategoryId' => 'SC001',
                'servicePrice' => 600.50,
                'serviceSize' => 2,
                'serviceIsActive' => 1,
            ),
        );
        DB::table('service')->insert($service);
    }
}
