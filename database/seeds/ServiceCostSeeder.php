<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ServiceCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sc = array (
            array(
            	'scId' => 'SERV0001',
				'scCost' => 500.00,
				'created_at' => Carbon::now(),
            )
        );
        DB::table('service_cost')->insert($sc);
    }
}
