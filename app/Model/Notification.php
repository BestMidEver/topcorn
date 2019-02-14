<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $fillable = [
    	'mode',
    	'user_id',
    	'multi_id',
    	'is_seen'
    ];
}