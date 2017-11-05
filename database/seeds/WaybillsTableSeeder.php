<?php

use Illuminate\Database\Seeder;

class WaybillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Waybill::class, 20)->create();
    }
}
