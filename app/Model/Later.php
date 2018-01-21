<?php

namespace App\Model;

use App\Model\Movie;
use Illuminate\Database\Eloquent\Model;

class Later extends Model
{
	 protected $fillable = [
    	'user_id',
    	'movie_id',
    ];

    public function movie(){
    	return $this->belongsTo(Movie::class);
    }
}
