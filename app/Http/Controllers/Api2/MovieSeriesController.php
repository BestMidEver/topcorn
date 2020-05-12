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
            'reviews' => []
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
    
}
