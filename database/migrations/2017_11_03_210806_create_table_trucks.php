<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrucks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('license_plate');
            $table->string('brand');
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
        Schema::dropIfExists('trucks');
    }
}
