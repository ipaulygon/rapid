<?php

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $package = array (
            array(
            	'packageId' => 'PACKAGE0001',
				'packageName' => 'Jumpackage',
				'packageDesc' => '',
                'packageCost' => 700.00,
				'packageIsActive' => 1,
            ),
        );
        DB::table('package')->insert($package);
    }
}
