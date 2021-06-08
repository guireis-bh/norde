<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->integer('family_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relatives', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['family_id']);
        });
        Schema::dropIfExists('relatives');
    }
}
