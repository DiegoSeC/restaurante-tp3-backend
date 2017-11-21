<?php

use Illuminate\Database\Seeder;

class TransferGuidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\TransferGuide::class, 30)->create();
        factory(App\Models\TransferGuideHasProduct::class, 200)->create();
    }
}
