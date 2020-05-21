<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Season_rated extends Model
{
    protected $fillable = [
        'user_id',
        'series_id',
    	'season_number',
    	'episode_number',
        'rate',
    ];
}
