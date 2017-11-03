<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWaybills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waybills', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('carrier_id')->unsigned();
            $table->integer('truck_id')->unsigned();
            $table->dateTime('date_time');
            $table->text('comment');
            $table->enum('delivery_status', ['pending', 'progress', 'completed']);
            $table->enum('status', ['active', 'canceled']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('carrier_id')->references('id')->on('carriers');
            $table->foreign('truck_id')->references('id')->on('trucks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waybill');
    }
}
