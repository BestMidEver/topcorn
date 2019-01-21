<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Series_recommendation extends Model
{
    public $incrementing = false;
    
    public $timestamps  = false;

    protected $fillable = [
        'id',
    	'this_id',
    	'series_id',
    	'rank',
    ];

    /*public function movie(){
    	return $this->belongsTo(Movie::class);
    }*/
}
