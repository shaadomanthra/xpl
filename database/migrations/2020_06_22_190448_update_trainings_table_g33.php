<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTrainingsTableG33 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('trainings', function (Blueprint $table) {
            $table->integer('tpo_id')->nullable();
            $table->integer('sessions')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('due_date')->nullable();
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
