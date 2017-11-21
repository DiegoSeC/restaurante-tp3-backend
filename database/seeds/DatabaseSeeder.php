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
        $this->call(WarehousesTableSeeder::class);
        $this->call(TrucksTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(CarriersTableSeeder::class);
        $this->call(WaybillsTableSeeder::class);
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
    }
}
