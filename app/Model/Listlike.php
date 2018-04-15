<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Listlike extends Model
{
    protected $fillable = [
    	'user_id',
    	'list_id'
    ];
}
