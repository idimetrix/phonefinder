<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToCountriesTable extends Migration
{
    public function up()
    {
        Schema::table('countries', function ($table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('countries', function ($table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}
