<?php

use Illuminate\Database\Seeder;
use App\Models\EvaluationRule;

class EvaluationRulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $evaluationRules = [
            ['uuid' => '3bf2d722-2f0b-4efa-afe4-ea9a06732717', 'description' => 'Puntualidad de entrega', 'percentage' => '20'],
            ['uuid' => '1c56f184-3f48-44e1-b0dc-6c1ef1f9ac84', 'description' => 'Calidad del producto', 'percentage' => '35'],
            ['uuid' => 'ed93c1e5-8e9f-430f-9109-0e6098ce72d8', 'description' => 'Precio del producto', 'percentage' => '25'],
            ['uuid' => '3d603af3-92c8-4fa5-9e0c-a4c25a1825e8', 'description' => 'Capacidad de respuesta', 'percentage' => '20']
        ];

        foreach ($evaluationRules as $rule) {
            EvaluationRule::firstOrCreate($rule);
        }

    }
}
