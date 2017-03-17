<?php

use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicle = array (
            array(
            	'vehicleId' => 'VEHICLE0001',
				'vehiclePlate' => 'DPG 296',
				'vehicleMakeId' => 'MAKE0001',
				'vehicleModelId' => 'MODEL0001',
				'vehicleYear' => '2016',
				'vehicleType' => 1,
				'vehicleEngine' => 1,
				'vehicleMileage' => 100,
				'vehicleIsActive' => 1
            ),
        );
        DB::table('vehicle')->insert($vehicle);
    }
}
