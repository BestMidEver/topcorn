<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomNotification extends Model
{
    protected $fillable = [
    	'mode',
    	'icon',
    	'en_notification',
    	'tr_notification',
    	'hu_notification'
    ];
}
