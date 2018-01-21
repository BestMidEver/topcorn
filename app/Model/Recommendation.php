<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    public $incrementing = false;
    
    public $timestamps  = false;

    protected $fillable = [
        'id',
    	'this_id',
    	'movie_id',
    	'is_similar',
    ];

    public function movie(){
    	return $this->belongsTo(Movie::class);
    }
}
