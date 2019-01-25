<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->integer('id')->primary()->unique();
            $table->string('original_name')->nullable();
            $table->double('vote_average',3,1)->nullable();
            $table->integer('vote_count')->nullable();
            $table->double('popularity',11,8)->nullable();
            $table->string('status')->nullable();
            $table->string('original_language')->nullable();
            $table->dateTime('first_air_date')->nullable();
            $table->dateTime('next_episode_air_date')->nullable();
            $table->dateTime('last_episode_air_date')->nullable();
            $table->string('en_name')->nullable();
            $table->string('tr_name')->nullable();
            $table->string('hu_name')->nullable();
            $table->string('en_poster_path')->nullable();
            $table->string('tr_poster_path')->nullable();
            $table->string('hu_poster_path')->nullable();
            $table->string('en_backdrop_path')->nullable();
            $table->string('tr_backdrop_path')->nullable();
            $table->string('hu_backdrop_path')->nullable();
            $table->text('en_plot')->nullable();
            $table->text('tr_plot')->nullable();
            $table->text('hu_plot')->nullable();
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
        Schema::dropIfExists('series');
    }
}
