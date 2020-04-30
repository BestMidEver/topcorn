<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Recent_user extends Model
{
    protected $fillable = [
       'user_id',
       'subject_id',
   ];
}
