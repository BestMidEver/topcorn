<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $incrementing = false;
    
    public $timestamps  = false;

 	protected $fillable = [
    	'id',
    ];

    public function movie(){
    	return $this->belongsTo(Movie::class);
    }
}
