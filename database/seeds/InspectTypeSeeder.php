<?php

use Illuminate\Database\Seeder;

class InspectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inspectType = array (
            array(
            	'inspectTypeId' => 'INSTYP001',
				'inspectTypeName' => 'Aircon',
				'inspectTypeDesc' => '',
				'inspectTypeIsActive' => 1,
            ),
            array(
            	'inspectTypeId' => 'INSTYP002',
				'inspectTypeName' => 'Tires',
				'inspectTypeDesc' => '',
				'inspectTypeIsActive' => 1,
            ),
        );
        DB::table('inspect_type')->insert($inspectType);
    }
}
