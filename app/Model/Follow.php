<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
    	'is_deleted',
    	'subject',
    	'object'
    ];
}
