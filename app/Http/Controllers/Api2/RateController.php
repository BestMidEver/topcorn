<?php

namespace App\Http\Controllers\Api2;

use App\Model\Ban;
use App\Model\Later;
use App\Model\Rated;
use App\Model\Review;
use App\Model\Series_ban;
use App\Jobs\SuckMovieJob;
use App\Jobs\SuckSeriesJob;
use App\Model\Series_later;
use App\Model\Series_rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if($review == ''){
            $reviewToDelete = Review::where(array('user_id' => Auth::id(), 'movie_series_id' => $request->obj_id, 'mode' => $mode, 'season_number' => null, 'episode_number' => null));
            $data = $reviewToDelete->first();
            if($data) $data = $data->id;
            else $data = -1;
            $reviewToDelete->delete();
        }
        else {
            $data = Review::updateOrCreate(
                array('user_id' => Auth::id(), 'movie_series_id' => $request->obj_id, 'mode' => $mode, 'season_number' => null, 'episode_number' => null),
                array('review' => $review, 'lang' => Auth::User()->lang)
            );

            $review = DB::table('reviews')
            ->where('reviews.id', $data->id)
            ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
            ->leftjoin('review_likes', function ($join) {
                $join->on('review_likes.review_id', '=', 'reviews.id')
                ->where('review_likes.is_deleted', '=', 0);
            })
            ->groupBy('reviews.id');

            if($data->mode == 1){
                $review = $review
                ->leftjoin('rateds as r1', function ($join) {
                    $join->on('r1.movie_id', '=', 'reviews.movie_series_id');
                    $join->on('r1.user_id', '=', 'reviews.user_id');
                });
            } else {
                $review = $review
                ->leftjoin('series_rateds as r1', function ($join) {
                    $join->on('r1.series_id', '=', 'reviews.movie_series_id');
                    $join->on('r1.user_id', '=', 'reviews.user_id');
                });
            }
            /* if($season_number != -1){
                if($episode_number != -1){
                    $review=$review
                    ->where('reviews.season_number', '=', $season_number)
                    ->where('reviews.episode_number', '=', $episode_number);
                }else{
                    $review=$review
                    ->where('reviews.season_number', '=', $season_number)
                    ->whereNull('reviews.episode_number');
                }
            }else{
                $review=$review
                ->whereNull('reviews.season_number')
                ->whereNull('reviews.episode_number');
            } */
            $review = $review
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id',
                'reviews.lang as url',
                'reviews.id as id',
                'users.name as name',
                'users.id as user_id',
                'r1.rate as rate',
                'reviews.movie_series_id as movie_series_id',
                DB::raw('COUNT(review_likes.id) as count'),
                DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
            );
            $data = $review->first()->toJson();
        }

        return Response::make($data, 200);
    }




    public function watchLaterAssign(Request $request, $type)
    {
        if($type === 'movie') return $this->watchLaterMovie($request);
        if($type === 'series') return $this->watchLaterSeries($request);
    }

    private function watchLaterMovie($request)
    {
        if($request->later > 0) {   
            Later::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->obj_id));
            SuckMovieJob::dispatch($request->obj_id, true)->onQueue("high");
        }
        else Later::where('user_id', Auth::id())->where('movie_id', $request->obj_id)->delete();

        return Response::make("", 204);
    }

    private function watchLaterSeries($request)
    {
        if($request->later > 0) {   
            Series_later::updateOrCreate(array('user_id' => Auth::id(), 'series_id' => $request->obj_id));
            SuckSeriesJob::dispatch($request->obj_id, true)->onQueue("high");
        }
        else Series_later::where('user_id', Auth::id())->where('series_id', $request->obj_id)->delete();

        return Response::make("", 204);
    }




    public function banAssign(Request $request, $type)
    {
        if($type === 'movie') return $this->banMovie($request);
        if($type === 'series') return $this->banSeries($request);
    }

    private function banMovie($request)
    {
        if($request->ban > 0) {   
            Ban::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->obj_id));
            SuckMovieJob::dispatch($request->obj_id, true)->onQueue("high");
        }
        else Ban::where('user_id', Auth::id())->where('movie_id', $request->obj_id)->delete();

        return Response::make("", 204);
    }

    private function banSeries($request)
    {
        if($request->ban > 0) {   
            Series_ban::updateOrCreate(array('user_id' => Auth::id(), 'series_id' => $request->obj_id));
            SuckSeriesJob::dispatch($request->obj_id, true)->onQueue("high");
        }
        else Series_ban::where('user_id', Auth::id())->where('series_id', $request->obj_id)->delete();

        return Response::make("", 204);
    }
}
