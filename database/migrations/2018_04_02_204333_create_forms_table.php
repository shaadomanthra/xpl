<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->string('name');
            $table->dateTime('dob')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->longText('education')->nullable();
            $table->longText('experience')->nullable();
            $table->longText('why')->nullable();
            $table->integer('status');
            $table->longText('reason')->nullable();
            $table->foreign('job_id')->references('id')->on('jobs');
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
        Schema::dropIfExists('forms');
    }
}
