<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MovieSeriesController extends Controller
{
    public function getMovieSeriesDataAssign(Request $request, $type, $objId, $season = -1, $episode = -1)
    {
        if($type === 'movie') return $this->getMovieData($request, $objId);
        if($type === 'series') return $this->getSeriesData($request, $objId, $season, $episode);
    }

    private function getMovieData($request, $objId)
    {
        return response()->json([
            'interactionData' => $this->movieSeriesCardData('movie', $objId),
            'reviews' => $this->reviewDataAssign($request,'movie', $objId),
        ]);
    }
    
    private function getSeriesData($request, $objId, $season = -1, $episode = -1)
    {
        return response()->json([
            'interactionData' => $this->movieSeriesCardData('series', $objId, $season, $episode),
            'reviews' => $this->reviewDataAssign($request,'series', $objId, $season, $episode),
        ]);
    }

    public function movieSeriesCardData($type, $objId, $season = -1, $episode = -1)
    {
        if($type === 'movie') return $this->movieCardData($objId);
        if($type === 'series' && $season == -1) return $this->seriesCardData($objId);
        else return $this->seasonCardData($objId, $season, $episode);
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
            //'rateds.id as rated_id',
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
        $return_val = DB::table('series')
        ->where('series.id', '=', $objId)
        ->leftjoin('series_rateds', function ($join) {
            $join->on('series_rateds.series_id', '=', 'series.id')
            ->where('series_rateds.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('series_laters', function ($join) {
            $join->on('series_laters.series_id', '=', 'series.id')
            ->where('series_laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('series_bans', function ($join) {
            $join->on('series_bans.series_id', '=', 'series.id')
            ->where('series_bans.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('series_recommendations', 'series_recommendations.this_id', '=', 'series.id')
        ->leftjoin('series_rateds as r2', function ($join) {
            $join->on('r2.series_id', '=', 'series_recommendations.series_id')
            ->where('r2.user_id', Auth::user()->id);
        })
        ->select(
            'series.id',
            'series.first_air_date',
            'series.original_name as original_name',
            'series.en_name as name',
            'series.en_backdrop_path as backdrop_path',
            //'series_rateds.id as rated_id',
            'series_rateds.rate as rate_code',
            'series_laters.id as later_id',
            'series_bans.id as ban_id',
            DB::raw('sum(IF(r2.rate > 0, ABS(r2.rate-3)*(r2.rate-3)*series_recommendations.rank, 0)) AS point'),
            DB::raw('sum(IF(r2.rate > 0, 4*series_recommendations.rank, 0)) as p2'),
            DB::raw('sum(IF(r2.rate > 0, 1, 0)) as count'),
            DB::raw('sum(IF(r2.rate > 0, r2.rate-1, 0))*25 DIV sum(IF(r2.rate > 0, 1, 0)) as percent')
        )
        ->groupBy('series.id');

        return response()->json($return_val->first());
    }

    private function seasonCardData($objId, $season, $episode)
    {
        $return_val = DB::table('series_seens')
        ->where('series_seens.series_id', $objId)
        ->where('series_seens.user_id', Auth::id())
        ->where('series_seens.season_number', $season)
        /* ->where('series_seens.episode_number', $episode)
        ->select(
            'series_seens.series_id',
            'series_seens.id as seen_id'
        ) */;

        return response()->json($return_val->first());
    }

    public function reviewDataAssign(Request $request, $type, $objId, $season, $episode)
    {
        if($type === 'movie') return $this->reviewData($request, $objId, [0, 1]);
        if($type === 'series') return $this->reviewData($request, $objId, [2, 3], $season, $episode);
    }
    
    private function reviewData($request, $objId, $modes, $season = -1, $episode = -1)
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

        if($season != -1){
            if($episode != -1){
                $review=$review
                ->where('reviews.season_number', '=', $season)
                ->where('reviews.episode_number', '=', $episode);
            }else{
                $review=$review
                ->where('reviews.season_number', '=', $season)
                ->whereNull('reviews.episode_number');
            }
        }else{
            $review=$review
            ->whereNull('reviews.season_number')
            ->whereNull('reviews.episode_number');
        }

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
        )
        ->orderBy('is_mine', 'desc')
        ->orderBy('count', 'desc');

        return $review->paginate(Auth::User()->pagination);
    }
    
    private function seriesReviewData($objId)
    {

    }
    
}
