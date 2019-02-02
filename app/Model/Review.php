<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
    	'mode',
    	'movie_series_id',
    	'season_number',
    	'episode_number',
    	'tmdb_author_name',
    	'tmdb_review_id',
    	'lang',
    	'user_id',
    	'review'
    ];
}
