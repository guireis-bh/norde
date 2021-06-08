<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->integer('family_id')->unsigned()->nullable();
            $table->integer('responsible_id')->unsigned()->nullable();
            $table->enum('responsible_kinship', ['parent', 'grandparent', 'parent_sibling', 'other'])->nullable();
            $table->string('other_kinship', 50)->nullable();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->integer('school_id')->unsigned()->nullable();
            $table->tinyInteger('service_id')->unsigned()->nullable();
            $table->date('entry_date');
            $table->date('grade');
            $table->string('subject')->nullable();
            $table->text('info')->nullable();
            $table->string('calendar_color', 7);
            $table->enum('payment_method', ['default', 'custom']);
            $table->double('payment_value', 8, 2);
            $table->tinyInteger('discount')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('responsible_id')->references('id')->on('relatives');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('teacher_id')->references('id')->on('employees');
            $table->foreign('school_id')->references('id')->on('schools');
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
        Schema::table('studants', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['family_id']);
            $table->dropForeign(['relatives_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['school_id']);
        });
        Schema::dropIfExists('studants');
    }
}
