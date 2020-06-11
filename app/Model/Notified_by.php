<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notified_by extends Model
{
	protected $table = 'notified_by';

    protected $fillable = [
    	'mode',
    	'subject_id',
    	'object_id'
    ];
}
