<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('status_id')->unsigned()->default(1);
            $table->integer('address_id')->unsigned()->default(1);
            $table->enum('salute', ['Sr.', 'Sra.','Dr.', 'Dra.'])->nullable();
            $table->string('surname')->default('Surname');
            $table->date('birthday')->default('1989-10-26');
            $table->string('rg', 14)->nullable()->unique();
            $table->string('cpf', 19)->nullable()->unique();
            $table->string('email2')->nullable();
            $table->string('cellphone', 50)->nullable();
            $table->string('homephone', 50)->nullable();
            $table->string('workphone', 50)->nullable();
            $table->string('know_from', 255)->nullable();

            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('address_id')->references('id')->on('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropForeign(['address_id']);
            $table->dropColumn('status_id');
            $table->dropColumn('address_id');
            $table->dropColumn('salute');
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('birthday');
            $table->dropColumn('rg');
            $table->dropColumn('cpf');
            $table->dropColumn('email2');
            $table->dropColumn('cellphone');
            $table->dropColumn('homephone');
            $table->dropColumn('workphone');
        });
    }
}
