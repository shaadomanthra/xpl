<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->longText('keywords')->nullable();
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
        Schema::dropIfExists('labels');
    }
}
