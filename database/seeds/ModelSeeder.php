<?php

use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = array (
            array(
            	'modelId' => 'MODEL0001',
				'modelName' => 'WIGO',
				'modelIsActive' => 1
            ),
        );
        DB::table('vehicle_model')->insert($model);
    }
}
