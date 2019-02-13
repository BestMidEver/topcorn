<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SentItem extends Model
{
    protected $fillable = [
    	'mode',
    	'sender_user_id',
    	'receiver_user_id',
    	'multi_id'
    ];
}
