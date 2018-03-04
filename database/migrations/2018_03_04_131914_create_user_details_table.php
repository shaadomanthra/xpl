<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('user_id')->unsigned();
            $table->longText('bio')->nullable();
            $table->string('designation')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->integer('privacy')->default(0);
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
