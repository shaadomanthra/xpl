<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->string('type')->nullable();
            $table->string('college_code')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('college_phone')->nullable();
            $table->string('college_email')->nullable();
            $table->string('college_website')->nullable();
            $table->string('tpo_name')->nullable();
            $table->string('tpo_email')->nullable();
            $table->string('tpo_email_2')->nullable();
            $table->string('tpo_phone')->nullable();
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
        Schema::dropIfExists('colleges');
    }
}
