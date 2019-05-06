<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticesCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices_course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('course_id')->nullable();
            $table->integer('attempted')->nullable();
            $table->integer('correct')->nullable();
            $table->integer('incorrect')->nullable();
            $table->bigInteger('time')->nullable();
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
        //
    }
}
