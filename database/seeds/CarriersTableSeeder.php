<?php

use Illuminate\Database\Seeder;

class CarriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Carrier::class, 10)->create();

        $carriers = App\Models\Carrier::all();
        foreach ($carriers as $carrier) {
            $carrier->update(['employee_id' => \Illuminate\Support\Facades\DB::raw('id')]);
        }
    }
}
