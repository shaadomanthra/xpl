<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('user_id')->unsigned();
            $table->longText('description')->nullable();
            $table->string('intro_youtube');
            $table->string('intro_vimeo');
            $table->integer('weightage_min');
            $table->integer('weightage_avg');
            $table->integer('weightage_max');
            $table->integer('price');
            $table->longText('important_topics');
            $table->longText('reference_books');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('courses');
    }
}
