<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('mode');//  0-reviewlike | 1-listlike | 2-newfeature | 3-seriesairdatechanged | 4-movierecommendation | 5-seriesrecommendation |

                                        //  6-watchtogetger
            $table->integer('user_id');
            $table->integer('multi_id');
            $table->tinyInteger('is_seen');
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
        Schema::dropIfExists('notifications');
    }
}
