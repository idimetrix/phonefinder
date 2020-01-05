<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number', 32)->index()->unique();
            $table->string('area_number', 16)->nullable();
            $table->string('short_number', 16)->index()->nullable();
            $table->string('prefix', 8)->nullable();
            $table->string('country', 32)->nullable();
            $table->string('aliases', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->integer('page')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('phone');
    }
}
