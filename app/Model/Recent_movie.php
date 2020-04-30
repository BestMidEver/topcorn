<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Recent_movie extends Model
{
    protected $fillable = [
       'user_id',
       'movie_id',
   ];
}
