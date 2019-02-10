<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
    	'mode',
    	'user_id',
    	'multi_id',
    	'is_seen'
    ];
}