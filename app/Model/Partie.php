<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    protected $fillable = [
    	'id',
    	'user_id',
    	'watched_with_user_id',
    	'created_at',
    	'updated_at',
    ];
}
