<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_items', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('mode');//  0-movie | 1-series
            $table->integer('sender_user_id');
            $table->integer('receiver_user_id');
            $table->integer('multi_id');
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
        Schema::dropIfExists('sent_items');
    }
}
