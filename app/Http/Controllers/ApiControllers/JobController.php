<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Jobs\SuckMovieJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function suck_movie($movie_id)
    {
        SuckMovieJob::dispatch($movie_id, false)->onQueue("high");
    }
}
