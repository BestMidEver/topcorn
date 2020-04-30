<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Recent_series extends Model
{
    protected $fillable = [
       'user_id',
       'series_id',
   ];
}
