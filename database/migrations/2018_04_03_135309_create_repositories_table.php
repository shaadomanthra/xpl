<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('user_id_data_manager')->unsigned();
            $table->integer('user_id_data_lead')->unsigned()->nullable();
            $table->foreign('user_id_data_manager')->references('id')->on('users');
            $table->foreign('user_id_data_lead')->references('id')->on('users');
            $table->integer('status');
            $table->dateTime('target')->nullable();
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
        Schema::dropIfExists('repositories');
    }
}
