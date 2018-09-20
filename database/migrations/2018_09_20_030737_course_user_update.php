<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourseUserUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('validity');
            $table->integer('client_id');
            $table->integer('credits');
            $table->dateTime('created_at');
            $table->dateTime('valid_till');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn(['id','validity','client_id','credits','created_at','valid_till']);
        });
    }
}
