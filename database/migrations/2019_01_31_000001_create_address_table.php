<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street');
            $table->string('number', 20)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('complement', 255)->nullable();
            $table->string('postalcode', 9);
            $table->string('country', 50);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['id', 'postalcode', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('address', function (Blueprint $table) {
            $table->dropIndex(['id', 'postalcode', 'number']);
        });
        Schema::dropIfExists('address');
    }
}
