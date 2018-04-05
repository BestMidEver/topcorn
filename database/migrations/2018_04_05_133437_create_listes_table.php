<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->text('entry_1')->nullable();
            $table->text('entry_2')->nullable();
            $table->tinyInteger('visibility')->default(1);
            $table->tinyInteger('sort')->default(1);
            $table->mediumInteger('fb_comment_count')->default(0);
            $table->mediumInteger('fb_share_count')->default(0);
            $table->mediumInteger('like_count')->default(0);
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
        Schema::dropIfExists('listes');
    }
}
