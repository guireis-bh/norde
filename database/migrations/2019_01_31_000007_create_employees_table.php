<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->tinyInteger('type_id')->unsigned();
            $table->text('bio')->nullable();
            $table->string('know_from')->nullable();
            $table->date('hiring_date');
            $table->enum('salary_type', ['default', 'custom']);
            $table->double('salary', 8, 2);
            $table->string('bank_name', 50);
            $table->string('bank_office', 10);
            $table->string('bank_account', 10);
            $table->string('bank_city', 50);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('type_id')->references('id')->on('employee_types');
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
        Schema::table('emploeeys', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['type_id']);
        });
        Schema::dropIfExists('emploeeys');
    }
}
