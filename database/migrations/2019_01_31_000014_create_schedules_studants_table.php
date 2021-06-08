<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesStudantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules_studants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id')->unsigned()->nullable();
            $table->integer('studant_id')->unsigned()->nullable();
            $table->time('time_reserved');
            $table->time('time_done')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('studant_id')->references('id')->on('studants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules_studants');
    }
}
