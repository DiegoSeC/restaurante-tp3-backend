<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('order_id')->unsigned();
            $table->string('document_number');
            $table->enum('status', ['pending', 'completed', 'canceled']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_requests');
    }
}
