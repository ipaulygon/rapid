<?php

use Illuminate\Database\Seeder;

class PackageProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = array (
            array(
            	'packagePId' => 'PACKAGE0001',
				'packageProductId' => 1,
				'packagePQty' => 1,
				'packagePIsActive' => 1,
            ),
            array(
                'packagePId' => 'PACKAGE0001',
                'packageProductId' => 2,
                'packagePQty' => 1,
                'packagePIsActive' => 1,
            ),
        );
        DB::table('package_product')->insert($packages);
    }
}
