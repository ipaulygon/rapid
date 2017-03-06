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
                'supplierPerson' => 'Juan Dela Cruz',
                'supplierContact' => '09054090523',
				'supplierAddress' => '',
				'supplierIsActive' => 1,
            ),
            array(
            	'supplierId' => 'SUPP0002',
				'supplierName' => 'Mobil',
                'supplierPerson' => 'Juan Dela Paz',
                'supplierContact' => '09054090523',
				'supplierAddress' => '',
				'supplierIsActive' => 1,
            ),
            array(
                'supplierId' => 'SUPP0003',
                'supplierName' => 'Bando',
                'supplierPerson' => 'Juan Dela Fuente',
                'supplierContact' => '09054090523',
                'supplierAddress' => '',
                'supplierIsActive' => 1,
            ),
        );
        DB::table('supplier')->insert($supplier);
    }
}
