<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExamsTableG34 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->integer('calculator')->nullable();
            $table->integer('capture_frequency')->nullable();
            $table->integer('window_swap')->nullable();
            $table->integer('auto_terminate')->nullable();
            $table->datetime('auto_activation')->nullable();
            $table->datetime('auto_deactivation')->nullable();

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
