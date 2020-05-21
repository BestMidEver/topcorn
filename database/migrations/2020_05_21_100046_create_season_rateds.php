<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonRateds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_rateds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id');
            $table->integer('user_id');
            $table->integer('season');
            $table->integer('episode');
            $table->tinyInteger('rate');
            $table->timestamps();
            $table->unique(['series_id', 'user_id', 'season', 'episode']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_rateds');
    }
}
