<?php

namespace App\Model;

use App\Model\Ban;
use App\Model\Later;
use App\Model\Rated;
use App\Model\Recommendation;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
    	'id',
    	'original_title',
    	'vote_average',
    	'original_language',
    	'release_date',
    	'popularity',
        'vote_count',
        'en_title',
        'tr_title',
        'hu_title',
        'en_poster_path',
        'tr_poster_path',
        'hu_poster_path',
        'en_cover_path',
        'tr_cover_path',
    	'hu_cover_path',
    ];

    public function genre(){
        return $this->hasMany(Genre::class);
    }    

    public function recommendation(){
    	return $this->hasMany(Recommendation::class);
    }

    public function rated(){
        return $this->hasMany(Rated::class);
    }    

    public function ban(){
        return $this->hasMany(Ban::class);
    }    
    
    public function later(){
        return $this->hasMany(Later::class);
    }
}
