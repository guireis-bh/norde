<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status_id')->unsigned();
            $table->integer('address_id')->unsigned();
            $table->string('name', 150)->unique();
            $table->string('webpage', 191)->unique();
            $table->text('config');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id', 'schools_status_id')->references('id')->on('status');
            $table->foreign('address_id', 'schools_address_id')->references('id')->on('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign('schools_status_id');
            $table->dropForeign('schools_address_id');
        });
        Schema::dropIfExists('schools');
    }
}
