<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->integer('id')->primary()->unique();
            $table->string('original_title')->nullable();
            $table->double('vote_average',3,1)->nullable();
            $table->integer('vote_count')->nullable();
            $table->double('popularity',11,8)->nullable();
            $table->string('original_language')->nullable();
            $table->dateTime('release_date')->nullable();
            $table->string('en_title')->nullable();
            $table->string('tr_title')->nullable();
            $table->string('hu_title')->nullable();
            $table->string('en_poster_path')->nullable();
            $table->string('tr_poster_path')->nullable();
            $table->string('hu_poster_path')->nullable();
            $table->string('en_cover_path')->nullable();
            $table->string('tr_cover_path')->nullable();
            $table->string('hu_cover_path')->nullable();
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
        Schema::dropIfExists('movies');
    }
}
