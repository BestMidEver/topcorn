<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Listitem extends Model
{
    protected $fillable = [
    	'user_id',
    	'movie_id',
    	'explanation'
    ];
}
