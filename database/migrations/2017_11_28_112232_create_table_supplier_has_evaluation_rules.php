<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSupplierHasEvaluationRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_has_evaluation_rules', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('evaluation_rule_id')->unsigned();
            $table->integer('supplier_id')->unsigned();
            $table->tinyInteger('value');
            $table->timestamps();

            $table->foreign('evaluation_rule_id')->references('id')->on('evaluation_rules');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_has_evaluation_rules');
    }
}
