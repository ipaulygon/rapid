<?php

use Illuminate\Database\Seeder;

class PackageServiceSeeder extends Seeder
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
            	'packageSId' => 'PACKAGE0001',
				'packageServiceId' => 'SERV0001',
				'packageSIsActive' => 1,
            ),
        );
        DB::table('package_service')->insert($packages);
    }
}
