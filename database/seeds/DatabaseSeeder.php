<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(VarianceSeeder::class);
        $this->call(ServiceCategorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(InspectTypeSeeder::class);
        $this->call(InspectItemSeeder::class);
        $this->call(DiscountSeeder::class);
        $this->call(TechSeeder::class);
        $this->call(ServiceCostSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductVarianceSeeder::class);
        $this->call(PromoSeeder::class);
        $this->call(PromoProductSeeder::class);
        $this->call(PromoServiceSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(PackageProductSeeder::class);
        $this->call(PackageServiceSeeder::class);
        $this->call(TypeVarianceSeeder::class);
        $this->call(TechSkillSeeder::class);
    }
}
