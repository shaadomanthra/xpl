<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpassagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpassages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('passage');
            $table->integer('user_id')->unsigned();
            $table->integer('repository_id')->unsigned();
            $table->integer('stage')->default(1);
            $table->integer('status')->default(0);
            $table->foreign('repository_id')->references('id')->on('repositories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('lpassages');
    }
}
