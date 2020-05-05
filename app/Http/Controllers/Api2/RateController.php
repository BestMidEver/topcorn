<?php

namespace App\Http\Controllers\Api2;

use App\Model\Rated;
use App\Jobs\SuckMovieJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function rateAssign(Request $request, $type)
    {
        if($type === 'movie') return $this->rateMovie($request);
    }

    private function rateMovie($request)
    {
        $rated = Rated::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->movie_id), array('rate' => $request->rate_code));
        SuckMovieJob::dispatch($request->movie_id, true)->onQueue("high");

        return Response::make("", 200);
    }
}
