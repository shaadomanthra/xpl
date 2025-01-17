<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_writer')->unsigned();
            $table->integer('user_id_moderator')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image');
            $table->longText('intro');
            $table->longText('content');
            $table->string('keywords');
            $table->integer('label_id');
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
        Schema::dropIfExists('blogs');
    }
}
