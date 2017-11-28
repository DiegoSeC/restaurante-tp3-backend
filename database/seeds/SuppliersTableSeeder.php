<?php

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\SupplierHasProduct;

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
        //factory(App\Models\SupplierHasProduct::class, 50)->create();

        $products = Product::all();

        foreach ($products as $product) {
            for ($i=0;$i<=4;$i++) {
                $supplier = Supplier::inRandomOrder()->first();
                SupplierHasProduct::firstOrCreate(['supplier_id' => $supplier->id, 'product_id' => $product->id]);
            }
        }
    }
}
