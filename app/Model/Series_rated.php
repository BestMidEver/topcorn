<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Series_rated extends Model
{
    protected $fillable = [
        'user_id',
        'series_id',
        'rate',
    ];

    /*public function movie(){
    	return $this->belongsTo(Movie::class);
    }*/
}
