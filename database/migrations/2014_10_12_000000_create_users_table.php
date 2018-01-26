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
            $table->string('lang')->default('en');
            $table->string('secondary_lang')->default('en');
            $table->tinyInteger('image_quality')->default(1);
            $table->tinyInteger('margin_x_setting')->default(0);
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
