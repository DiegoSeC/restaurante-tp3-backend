<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWarehouses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('code');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone_number');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('status', ['active', 'inactive']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
