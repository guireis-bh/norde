<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 191);
            $table->enum('type', ['boolean', 'numeric', 'string']);
            $table->string('value');
            $table->integer('user_id')->unsigned();
            $table->unique(['key', 'user_id']);
            $table->timestamps();
            $table->softDeletes();
            
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
        Schema::table('configs', function (Blueprint $table) {
            $table->dropUnique(['key', 'user_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('configs');
    }
}
