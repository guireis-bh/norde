<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('slug', 50)->unique();
            $table->string('label', 100);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status', function (Blueprint $table) {
            $table->dropIndex(['id', 'slug']);
        });
        Schema::dropIfExists('status');
    }
}
