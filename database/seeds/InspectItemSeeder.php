<?php

use Illuminate\Database\Seeder;

class InspectItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inspectItem = array (
            array(
            	'inspectItemId' => 'INSITEM0001',
            	'inspectItemTypeId' => 'INSTYP001',
				'inspectItemName' => 'Temperature',
				'inspectItemDesc' => '',
				'inspectItemIsActive' => 1,
            ),
        );
        DB::table('inspect_item')->insert($inspectItem);
    }
}
