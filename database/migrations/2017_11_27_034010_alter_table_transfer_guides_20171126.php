<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransferGuides20171126 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfer_guides', function (Blueprint $table) {
            $table->integer('warehouse_from_id')->unsigned();
            $table->integer('warehouse_to_id')->unsigned();

            $table->foreign('warehouse_from_id')->references('id')->on('warehouses');
            $table->foreign('warehouse_to_id')->references('id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_guides', function (Blueprint $table) {
            $table->dropForeign(['warehouse_from_id']);
            $table->dropForeign(['warehouse_to_id']);

            $table->dropColumn('warehouse_from_id');
            $table->dropColumn('warehouse_to_id');
        });
    }
}
