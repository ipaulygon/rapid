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
            array(
                'inspectItemId' => 'INSITEM0002',
                'inspectItemTypeId' => 'INSTYP002',
                'inspectItemName' => 'Left Front Tire',
                'inspectItemDesc' => '',
                'inspectItemIsActive' => 1,
            ),
            array(
                'inspectItemId' => 'INSITEM0003',
                'inspectItemTypeId' => 'INSTYP002',
                'inspectItemName' => 'Left Rear Tire',
                'inspectItemDesc' => '',
                'inspectItemIsActive' => 1,
            ),
            array(
                'inspectItemId' => 'INSITEM0004',
                'inspectItemTypeId' => 'INSTYP002',
                'inspectItemName' => 'Right Front Tire',
                'inspectItemDesc' => '',
                'inspectItemIsActive' => 1,
            ),
            array(
                'inspectItemId' => 'INSITEM0005',
                'inspectItemTypeId' => 'INSTYP002',
                'inspectItemName' => 'Right Rear Tire',
                'inspectItemDesc' => '',
                'inspectItemIsActive' => 1,
            ),
        );
        DB::table('inspect_item')->insert($inspectItem);
    }
}
