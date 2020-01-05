<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexForColumnPhoneIdForDifferentTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function ($table) {
            $table->index('phoneId');
        });

        Schema::table('likes', function ($table) {
            $table->index('phoneId');
        });

        Schema::table('views', function ($table) {
            $table->index('phoneId');
        });

        Schema::table('search', function ($table) {
            $table->index('phoneId');
        });
    }

    public function down()
    {
        Schema::table('comments', function ($table) {
            $table->dropIndex(['phoneId']);
        });

        Schema::table('likes', function ($table) {
            $table->dropIndex(['phoneId']);
        });

        Schema::table('views', function ($table) {
            $table->dropIndex(['phoneId']);
        });

        Schema::table('search', function ($table) {
            $table->dropIndex(['phoneId']);
        });
    }
}
