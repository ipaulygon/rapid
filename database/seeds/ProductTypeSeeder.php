<?php

use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array (
            array(
            	'typeId' => 'TYPE001',
				'typeName' => 'Oil',
				'typeDesc' => 'Langis',
				'typeIsActive' => 1,
            ),
            array(
            	'typeId' => 'TYPE002',
				'typeName' => 'Fuel',
				'typeDesc' => 'Krudo',
				'typeIsActive' => 1,
            ),
            array(
                'typeId' => 'TYPE003',
                'typeName' => 'Belt',
                'typeDesc' => '',
                'typeIsActive' => 1,
            ),
        );
        DB::table('product_type')->insert($types);
    }
}
