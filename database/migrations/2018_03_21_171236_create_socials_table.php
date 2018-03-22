<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_writer')->unsigned();
            $table->integer('user_id_moderator')->unsigned();
            $table->integer('network');
            $table->string('image');
            $table->longText('content');
            $table->integer('status');
            $table->dateTime('schedule');
            $table->foreign('user_id_writer')->references('id')->on('users');
            $table->foreign('user_id_moderator')->references('id')->on('users');
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
        Schema::dropIfExists('socials');
    }
}
