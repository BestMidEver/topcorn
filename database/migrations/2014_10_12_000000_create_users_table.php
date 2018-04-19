<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facebook_id');
            $table->string('name');
            $table->string('cover_pic')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('facebook_profile_pic')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('another_link_name')->nullable();
            $table->string('another_link_url')->nullable();
            $table->string('lang')->default('en');
            $table->string('secondary_lang')->default('en');
            $table->tinyInteger('hover_title_language')->default(0);
            $table->tinyInteger('image_quality')->default(1);
            $table->tinyInteger('margin_x_setting')->default(1);
            $table->tinyInteger('open_new_tab')->default(1);
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('tt_navbar')->default(0);
            $table->tinyInteger('tt_recommendations')->default(0);
            $table->tinyInteger('tt_search')->default(0);
            $table->tinyInteger('tt_quickvote')->default(0);
            $table->tinyInteger('tt_profile')->default(0);
            $table->tinyInteger('tt_account')->default(0);
            $table->tinyInteger('tt_movie')->default(0);
            $table->tinyInteger('advanced_filter')->default(0);
            $table->tinyInteger('show_crew')->default(0);
            $table->tinyInteger('pagination')->default(24);
            $table->tinyInteger('theme')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
