<?php

namespace App\Model;

use App\Model\Movie;
use Illuminate\Database\Eloquent\Model;

class Rated extends Model
{
    protected $fillable = [
    	'user_id',
    	'movie_id',
    	'rate',
    ];

    public function movie(){
    	return $this->belongsTo(Movie::class);
    }
}
