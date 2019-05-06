<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('referral_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('referral_id')->references('id')->on('users');
            $table->string('name');
            $table->string('referral');
            $table->string('company');
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
