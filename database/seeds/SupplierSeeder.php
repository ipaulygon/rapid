<?php

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier = array (
            array(
            	'supplierId' => 'SUPP0001',
				'supplierName' => 'Caltex',
				'supplierDesc' => '',
				'supplierIsActive' => 1,
            ),
            array(
            	'supplierId' => 'SUPP0002',
				'supplierName' => 'Mobil',
				'supplierDesc' => '',
				'supplierIsActive' => 1,
            ),
            array(
                'supplierId' => 'SUPP0003',
                'supplierName' => 'Bando',
                'supplierDesc' => '',
                'supplierIsActive' => 1,
            ),
        );
        DB::table('supplier')->insert($supplier);
    }
}
