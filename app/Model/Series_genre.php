<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Series_genre extends Model
{
    public $incrementing = false;
    
    public $timestamps  = false;

 	protected $fillable = [
    	'id',
    	'series_id',
    	'genre_id'
    ];

    /*public function movie(){
    	return $this->belongsTo(Movie::class);
    }*/
}
