<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stream_id');
            $table->integer('location_id');
            $table->integer('company_id');
            $table->string('title');
            $table->string('position')->nullable();
            $table->string('salary')->nullable();
            $table->integer('vacancies')->nullable();
            $table->longText('eligibility')->nullable();
            $table->longText('description')->nullable();
            $table->DateTime('last_date')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('openings');
    }
}
