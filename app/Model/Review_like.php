<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review_like extends Model
{
    protected $fillable = [
    	'is_deleted',
    	'user_id',
    	'subject_id',
    	'review_id'
    ];
}
