<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Recent_list extends Model
{
    protected $fillable = [
       'user_id',
       'list_id',
   ];
}
