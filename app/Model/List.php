<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class List extends Model
{
    protected $fillable = [
    	'user_id',
    	'title',
    	'entry_1',
    	'entry_2',
    	'visibility',
    	'sort',
    	'fb_comment_count',
    	'fb_share_count',
    	'like_count'
    ];
}
