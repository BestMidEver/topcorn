<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review_like extends Model
{
    protected $fillable = [
    	'user_id',
    	'review_id'
    ];
}
