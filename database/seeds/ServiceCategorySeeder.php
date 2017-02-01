<?php

use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = array (
            array(
            	'categoryId' => 'SC001',
				'categoryName' => 'Maintenance',
				'categoryDesc' => '',
				'categoryIsActive' => 1,
            )
        );
        DB::table('service_category')->insert($category);
    }
}
