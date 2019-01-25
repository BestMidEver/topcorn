<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
    	'id',
    	'original_name',
    	'vote_average',
    	'original_language',
    	'first_air_date',
    	'next_episode_air_date',
    	'last_episode_air_date',
        'popularity',
    	'status',
        'vote_count',
        'en_name',
        'tr_name',
        'hu_name',
        'en_poster_path',
        'tr_poster_path',
        'hu_poster_path',
        'en_backdrop_path',
        'tr_backdrop_path',
        'hu_backdrop_path',
        'en_plot',
        'tr_plot',
    	'hu_plot',
    ];

    /*public function genre(){
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
    }*/
}
