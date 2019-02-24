<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Jobs\SuckMovieJob;
use App\Jobs\SuckSeriesJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function suck_movie($movie_id)
    {
        SuckMovieJob::dispatch($movie_id, false)->onQueue("high");
    }



    public function suck_series($series_id)
    {
        SuckSeriesJob::dispatch($series_id, false)->onQueue("high");
    }
}
