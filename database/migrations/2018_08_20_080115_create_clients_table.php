<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('user_id_creator')->unsigned();
            $table->integer('user_id_owner')->unsigned()->nullable();
            $table->integer('user_id_manager')->unsigned()->nullable();
            $table->foreign('user_id_creator')->references('id')->on('users');
            $table->foreign('user_id_owner')->references('id')->on('users');
            $table->foreign('user_id_manager')->references('id')->on('users');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
