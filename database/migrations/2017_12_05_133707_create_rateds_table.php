<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rateds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('movie_id');
            $table->integer('user_id');
            $table->tinyInteger('rate');
            $table->timestamps();
            $table->unique(['movie_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rateds');
    }
}
