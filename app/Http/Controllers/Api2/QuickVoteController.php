<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuickVoteController extends Controller
{
    public function getQuickVoteAssign($type, $objId = null)
    {
        if($type === 'movie') {
            if($objId !== null) return $this->getRelatedMovies($objId);
            return $this->getQuickVoteMovies();
        }
        if($type === 'series') return $this->getQuickVoteSeries();
    }

    private function getRelatedMovies($objId)
    {
        $movies = DB::table('recommendations')
        ->where('recommendations.this_id', $objId)
        ->leftjoin('rateds', function ($join) {
            $join->on('rateds.movie_id', '=', 'recommendations.movie_id')
            ->where('rateds.user_id', Auth::id());
        })
        //->where('rateds.user_id', null)
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'recommendations.movie_id')
            ->where('laters.user_id', Auth::id());
        })
        ->where('laters.id', '=', null)
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'recommendations.movie_id')
            ->where('bans.user_id', Auth::id());
        })
        ->where('bans.id', '=', null)
        ->join('movies', 'movies.id', '=', 'recommendations.movie_id')
        ->select(
            'movies.original_title'
        );

        
        return response()->json($movies->get());
    }

    private function getQuickVoteMovies($objId)
    {
        $return_val = DB::table('rateds')
        ->where('rateds.rate', '>', 0)
        ->join('movies', 'movies.id', '=', 'rateds.movie_id')
        ->leftjoin('rateds as r2', function ($join) {
            $join->on('r2.movie_id', '=', 'movies.id')
            ->where('r2.user_id', Auth::id());
        })
        ->where('r2.user_id', null)
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', Auth::id());
        })
        ->where('laters.id', '=', null)
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->where('bans.user_id', Auth::id());
        })
        ->where('bans.id', '=', null)
        ->groupBy('movies.id')
        ->orderBy('count', 'DESC')
        ->select(
            'movies.id as id',
            'movies.original_title as original_title',
            DB::raw('COUNT(*) as count'),
            'movies.vote_average',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_cover_path as cover_path',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->take(10)->get();

        if($return_val->count()) return $return_val;
        else {
            $return_val = DB::table('movies')
            ->leftjoin('rateds as rateds', function ($join) {
                $join->on('rateds.movie_id', '=', 'movies.id')
                ->where('rateds.user_id', Auth::id());
            })
            ->where('rateds.user_id', null)
            ->leftjoin('laters', function ($join) {
                $join->on('laters.movie_id', '=', 'movies.id')
                ->where('laters.user_id', Auth::id());
            })
            ->where('laters.id', '=', null)
            ->leftjoin('bans', function ($join) {
                $join->on('bans.movie_id', '=', 'movies.id')
                ->where('bans.user_id', Auth::id());
            })
            ->select(
                'movies.id as id',
                'movies.original_title as original_title',
                'movies.vote_average',
                'movies.release_date',
                'movies.'.Auth::User()->lang.'_title as title',
                'movies.'.Auth::User()->lang.'_cover_path as cover_path',
                'rateds.rate as rate_code',
                'laters.id as later_id',
                'bans.id as ban_id'
            )
            ->where('bans.id', '=', null)
            ->inRandomOrder();

            return $return_val->take(50)->get();
        }
        
    }
}
