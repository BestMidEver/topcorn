<?php

namespace App\Http\Controllers\Api2;

use App\Model\Rated;
use App\Jobs\SuckMovieJob;
use App\Jobs\SuckSeriesJob;
use App\Model\Series_rated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RateController extends Controller
{
    public function rateAssign(Request $request, $type)
    {
        if($type === 'movie') return $this->rateMovie($request);
        if($type === 'series') return $this->rateSeries($request);
    }

    private function rateMovie($request)
    {
        if($request->rate_code >= 0) {
            Rated::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->obj_id), array('rate' => $request->rate_code));
            SuckMovieJob::dispatch($request->obj_id, true)->onQueue("high");
        }
        if($request->rate_code == -1) Rated::where('user_id', Auth::id())->where('movie_id', $request->obj_id)->delete();

        return Response::make("", 204);
    }

    private function rateSeries($request)
    {
        if($request->rate_code >= 0) {
            Series_rated::updateOrCreate(array('user_id' => Auth::id(), 'series_id' => $request->obj_id), array('rate' => $request->rate_code));
            SuckSeriesJob::dispatch($request->obj_id, true)->onQueue("high");
        }
        if($request->rate_code == -1) Series_rated::where('user_id', Auth::id())->where('series_id', $request->obj_id)->delete();

        return Response::make("", 204);
    }
}
