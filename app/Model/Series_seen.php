<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Series_seen extends Model
{
    protected $fillable = [
    	'user_id',
    	'series_id',
    	'status',
    	'season_number',
    	'episode_number',
    	'air_date',
    	'next_season',
    	'next_episode',
    ];
}
