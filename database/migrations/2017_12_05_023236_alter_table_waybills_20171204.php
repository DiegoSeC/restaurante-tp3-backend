<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWaybills20171204 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waybills', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });

        Schema::table('waybills', function (Blueprint $table) {
            $table->integer('transfer_guide_id')->unsigned()->nullable();
            $table->foreign('transfer_guide_id')->references('id')->on('transfer_guides');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waybills', function (Blueprint $table) {
            $table->dropForeign(['transfer_guide_id']);
            $table->dropColumn('transfer_guide_id');
        });

        Schema::table('waybills', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }
}
