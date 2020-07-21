<?php

namespace App\Http\Controllers\Api2;

use App\User;
use App\Model\Ban;
use Carbon\Carbon;
use App\Model\Later;
use App\Model\Rated;
use App\Model\Follow;
use App\Model\Review;
use App\Model\Series_ban;
use App\Jobs\SuckMovieJob;
use App\Model\Notified_by;
use App\Model\Series_seen;
use App\Jobs\SuckSeriesJob;
use App\Model\Notification;
use App\Model\Series_later;
use App\Model\Series_rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendNotificationEmailJob;
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




    public function getUserReview($type, $objId, $season = -1, $episode = -1)
    {
        if($type === 'movie') return $this->getMovieSeriesReview(1, $objId);
        if($type === 'series') return $this->getMovieSeriesReview(3, $objId, $season, $episode);
        if($type === 'person') return $this->getMovieSeriesReview(4, $objId);
    }

    private function getMovieSeriesReview($mode, $objId, $season_number = -1, $episode_number = -1)
    {
        $review = DB::table('reviews')
        ->where('mode', $mode)
        ->where('user_id', Auth::id())
        ->where('movie_series_id', $objId)
        ->select(
            'id',
            'movie_series_id',
            'review',
            DB::raw($season_number . ' as season_number'),
            DB::raw($episode_number . ' as episode_number')
        );

        if($season_number != -1){
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
        }


        return response()->json($review->first());
    }


    public function sendReview(Request $request, $type) {
        if($type === 'movie') return $this->sendMovieSeriesReview(1, $request);
        if($type === 'series') return $this->sendMovieSeriesReview(3, $request);
        if($type === 'person') return $this->sendMovieSeriesReview(4, $request);
    }

    private function sendMovieSeriesReview($mode, $request)
    {
        $review = strip_tags($request->review);
        $whereArray = array(
            'user_id' => Auth::id(),
            'movie_series_id' => $request->obj_id,
            'mode' => $mode,
            'season_number' => $request->season_number == -1 || $mode == 1 || $mode == 4 ? null : $request->season_number,
            'episode_number' => $request->episode_number == -1 || $mode == 1 || $mode == 4 ? null : $request->episode_number
        );
        if($review == ''){
            $reviewToDelete = Review::where($whereArray);
            $data = $reviewToDelete->first();
            if($data) $data = $data->id;
            else $data = -1;
            //Notification::where('user_id', Auth::id())->where('mode', 0)->delete();
            $reviewToDelete->delete();
        } else {
            $data = Review::updateOrCreate($whereArray, array('review' => $review, 'lang' => Auth::User()->lang));

            $review = DB::table('reviews')
            ->where('reviews.id', $data->id)
            ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
            ->leftjoin('review_likes', function ($join) {
                $join->on('review_likes.review_id', '=', 'reviews.id')
                ->where('review_likes.is_deleted', '=', 0);
            })
            ->groupBy('reviews.id');
            if($data->mode == 4){
                $review = $review
                ->select(
                    'reviews.review as content',
                    'reviews.lang',
                    'reviews.id as id',
                    'users.name as name',
                    'users.id as user_id',
                    'reviews.movie_series_id as movie_series_id',
                    DB::raw('COUNT(review_likes.id) as count'),
                    DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                    DB::raw('IF(reviews.user_id = '.Auth::id().', 1, 0) as is_mine')
                );
            } else {
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
                $review = $review
                ->select(
                    'reviews.tmdb_author_name as author',
                    'reviews.review as content',
                    'reviews.tmdb_review_id',
                    'reviews.lang',
                    'reviews.season_number',
                    'reviews.episode_number',
                    'reviews.id as id',
                    'users.name as name',
                    'users.id as user_id',
                    'r1.rate as rate',
                    'reviews.movie_series_id as movie_series_id',
                    DB::raw('COUNT(review_likes.id) as count'),
                    DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                    DB::raw('IF(reviews.user_id = '.Auth::id().', 1, 0) as is_mine')
                );
            }
            $data = $review->first();
        }
        return response()->json($data, 200);
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




    public function lastSeen(Request $request)
    {
        if($request->last_seen > 0) {   
            Series_seen::updateOrCreate(
                array('user_id' => Auth::id(), 'series_id' => $request->series_id), 
                array(
                    'season_number' => $request->last_seen_season,
                    'episode_number' => $request->last_seen_episode,
                    'air_date' => new Carbon($request->air_date),
                    'next_season' => $request->next_season,
                    'next_episode' => $request->next_episode
                )
            );
        }
        else Series_seen::where('user_id', Auth::id())->where('series_id', $request->series_id)->delete();

        return Response::make("", 204);
    }




    public function followAssign(Request $request)
    {
        if($request->follow > 0) {   
            $follow = Follow::updateOrCreate(array('subject_id' => Auth::id(), 'object_id' => $request->obj_id), array('is_deleted' => 0));
            if($follow->wasRecentlyCreated && User::find($request->obj_id)->when_user_interaction > 0){
                $notification = Notification::updateOrCreate(['mode' => 8, 'user_id' => $request->obj_id, 'multi_id' => Auth::id()], ['is_seen' => 0]);
                if(User::find($request->obj_id)->when_user_interaction > 1) SendNotificationEmailJob::dispatch($notification->id)->onQueue("high");
            }
        } else {
            $follow = Follow::updateOrCreate(array('subject_id' => Auth::id(), 'object_id' => $request->obj_id), array('is_deleted' => 1));
            Notification::where('multi_id', Auth::id())->where('user_id', $request->obj_id)->where('mode', 8)->delete();
        }

        return Response::make("", 204);
    }




    public function notifiedByAssign(Request $request, $type)
    {
        if($type === 'user') return $this->notifiedBy($request, 0);
    }
    
    public function notifiedBy(Request $request, $mode)
    {
        if($request->notified_by > 0) {   
            Notified_by::updateOrCreate(array('subject_id' => Auth::id(), 'object_id' => $request->obj_id, 'mode' => $mode));
        }
        else Notified_by::where('subject_id', Auth::id())->where('object_id', $request->obj_id)->where('mode', $mode)->delete();

        return Response::make("", 204);
    }
}
