<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'facebook_id', 'facebook_link', 'twitter_link', 'instagram_link', 'youtube_link', 'another_link_name', 'another_link_url', 'profile_pic', 'facebook_profile_pic', 'lang', 'secondary_lang', 'image_quality', 'margin_x_setting', 'open_new_tab', 'hover_title_language', 'tt_navbar', 'tt_recommendations', 'tt_search', 'tt_quickvote', 'tt_profile', 'tt_account', 'tt_movie', 'advanced_filter', 'show_crew', 'pagination', 'theme'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
