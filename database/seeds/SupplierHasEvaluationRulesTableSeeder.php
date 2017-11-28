<?php

use Illuminate\Database\Seeder;
use App\Models\EvaluationRule;
use App\Models\Supplier;
use App\Models\SupplierHasEvaluationRule;

class SupplierHasEvaluationRulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $suppliers = Supplier::all();
        $evaluationRules = EvaluationRule::all();

        foreach ($suppliers as $supplier) {
            foreach ($evaluationRules as $rule) {
                $supplierEvaluationRule = SupplierHasEvaluationRule::firstOrCreate(['supplier_id' => $supplier->id, 'evaluation_rule_id' => $rule->id]);
                $supplierEvaluationRule->value = rand(1, 5);
                $supplierEvaluationRule->save();
            }
        }

    }
}
