<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Supplier::class, 10)->create();
        factory(App\Models\SupplierHasProduct::class, 50)->create();
    }
}
