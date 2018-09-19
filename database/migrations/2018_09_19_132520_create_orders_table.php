<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('order_id');
            $table->string('txn_id')->nullable();
            $table->string('package');
            $table->string('payment_mode')->nullable();
            $table->string('bank_txn_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('txn_amount');
            $table->integer('status'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('orders');
    }
}
