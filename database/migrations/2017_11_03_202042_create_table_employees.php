<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->uuid('user_uuid');
            $table->integer('role_id')->unsigned();
            $table->string('document_number');
            $table->string('name');
            $table->string('last_name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
