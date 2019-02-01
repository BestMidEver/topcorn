<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('mode');//  0-movie tmdb | 1-movie topcorn | 2-series tmdb | 3-series topcorn
            $table->integer('movie_series_id');// [0,1]-movie id | [2,3]-series id
            $table->integer('season_number')->nullable();// 3-season number
            $table->integer('episode_number')->nullable();// 3-episode number
            $table->string('tmdb_author_name')->nullable();
            $table->string('tmdb_review_id')->nullable();
            $table->string('lang')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('review')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
