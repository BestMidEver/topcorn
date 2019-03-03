<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
    	'id',
    	'profile_path',
    	'name',
    	'popularity',
    	'birthday',
    	'deathday'
    ];
}
