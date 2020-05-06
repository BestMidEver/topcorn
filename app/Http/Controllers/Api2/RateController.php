<?php

namespace App\Http\Controllers\Api2;

use App\Model\Rated;
use App\Model\Review;
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




    public function getUserReview($type, $objId)
    {
        if($type === 'movie') return $this->getMovieSeriesReview(1, $objId);
        if($type === 'series') return $this->getMovieSeriesReview(3, $objId);
    }

    private function getMovieSeriesReview($mode, $objId)
    {
        $review = Review::where('mode', $mode)
        ->where('user_id', Auth::id())
        ->where('movie_series_id', $objId)
        ->select(
            'id',
            'movie_series_id',
            'review'
        );

        return response()->json($review->first());
    }


    public function sendReview(Request $request, $type) {
        if($type === 'movie') return $this->sendMovieSeriesReview(1, $request);
        if($type === 'series') return $this->sendMovieSeriesReview(3, $request);
    }

    private function sendMovieSeriesReview($mode, $request)
    {
        $review = strip_tags($request->review);
        if($review == '') Review::where(array('user_id' => Auth::id(), 'movie_series_id' => $request->obj_id, 'mode' => $mode, 'season_number' => null, 'episode_number' => null))->delete();
        else Review::updateOrCreate(
            array('user_id' => Auth::id(), 'movie_series_id' => $request->obj_id, 'mode' => $mode, 'season_number' => null, 'episode_number' => null),
            array('review' => $review, 'lang' => Auth::User()->lang)
        );

        return Response::make("", 204);
    }
}
