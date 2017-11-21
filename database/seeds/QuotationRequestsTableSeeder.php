<?php

use Illuminate\Database\Seeder;

class QuotationRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\QuotationRequest::class, 30)->create();
        factory(App\Models\QuotationRequestHasProduct::class, 200)->create();
    }
}
