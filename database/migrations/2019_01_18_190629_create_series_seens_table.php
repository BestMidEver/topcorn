<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesSeensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_seens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id');
            $table->integer('user_id');
            $table->integer('season_number');
            $table->integer('episode_number');
            $table->dateTime('air_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->unique(['series_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_seens');
    }
}
