<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Series_ban extends Model
{
 	protected $fillable = [
    	'user_id',
    	'series_id',
    ];

    /*public function movie(){
    	return $this->belongsTo(Movie::class);
    }*/
}
