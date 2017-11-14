<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWarehouseHasProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_has_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('stock')->unsigned();
            $table->integer('minimum_stock')->unsigned();
            $table->integer('maximum_stock')->unsigned();
            $table->timestamps();

            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_has_products');
    }
}
