<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MovieSeriesController extends Controller
{
    public function getMovieSeriesDataAssign($type, $objId)
    {
        if($type === 'movie') return $this->getMovieData($objId);
        if($type === 'series') return $this->getSeriesData($objId);
    }

    private function getMovieData($objId)
    {
        return response()->json([
            'interactionData' => $this->movieSeriesCardData('movie', $objId),
            'reviews' => $this->reviewDataAssign('movie', $objId),
        ]);
    }
    
    private function getSeriesData($objId)
    {

    }

    public function movieSeriesCardData($type, $objId)
    {
        if($type === 'movie') return $this->movieCardData($objId);
        if($type === 'series') return $this->seriesCardData($objId);
    }

    private function movieCardData($objId)
    {
        $return_val = DB::table('movies')
        ->where('movies.id', '=', $objId)
        ->leftjoin('rateds', function ($join) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->where('rateds.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->where('bans.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('recommendations', 'recommendations.this_id', '=', 'movies.id')
        ->leftjoin('rateds as r2', function ($join) {
            $join->on('r2.movie_id', '=', 'recommendations.movie_id')
            ->where('r2.user_id', Auth::user()->id);
        })
        ->select(
            'movies.id',
            'movies.release_date',
            'movies.original_title as original_title',
            'movies.en_title as title',
            'movies.en_cover_path as cover_path',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id',
            DB::raw('sum(IF(r2.rate > 0, ABS(r2.rate-3)*(r2.rate-3)*recommendations.is_similar, 0)) AS point'),
            DB::raw('sum(IF(r2.rate > 0, 4*recommendations.is_similar, 0)) as p2'),
            DB::raw('sum(IF(r2.rate > 0, 1, 0)) as count'),
            DB::raw('sum(IF(r2.rate > 0, r2.rate-1, 0))*25 DIV sum(IF(r2.rate > 0, 1, 0)) as percent')
        )
        ->groupBy('movies.id');

        return response()->json($return_val->first());

    }
    
    private function seriesCardData($objId)
    {

    }

    public function reviewDataAssign($type, $objId)
    {
        if($type === 'movie') return $this->reviewData($objId, [0, 1]);
        if($type === 'series') return $this->reviewData($objId, [2, 3]);
    }
    
    private function reviewData($objId, $modes, $episode_number = -1, $season_number = -1)
    {
        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $objId)
        ->whereIn('reviews.mode', $modes)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id')
            ->where('review_likes.is_deleted', '=', 0);
        })
        ->groupBy('reviews.id');

        if($modes[0]==0){
            $review=$review
            ->leftjoin('rateds as r1', function ($join) {
                $join->on('r1.movie_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }else{
            $review=$review
            ->leftjoin('series_rateds as r1', function ($join) {
                $join->on('r1.series_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }

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

        if(Auth::check()){
            $review = $review
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                'r1.rate as rate',
                'reviews.movie_series_id as movie_series_id',
                DB::raw('COUNT(review_likes.id) as count'),
                DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
            )
            ->orderBy('is_mine', 'desc')
            ->orderBy('count', 'desc');
        }else{
            $review = $review
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                'r1.rate as rate',
                DB::raw('COUNT(review_likes.id) as count')
            )
            ->orderBy('count', 'desc');
        }

        return $review->paginate(25);
    }
    
    private function seriesReviewData($objId)
    {

    }
    
}
