<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Recent_person extends Model
{
    protected $fillable = [
       'user_id',
       'person_id',
   ];
}
