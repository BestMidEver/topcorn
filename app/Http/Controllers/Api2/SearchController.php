<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function recenltyVisiteds()
    {
        $movies = DB::table('recent_movies')
        ->where('recent_movies.id', Auth::user()->id)
        /* ->join('movies', 'movies.id', '=', 'recent_movies.movie_id')
        ->leftjoin('rateds', function ($join) {
            $join->on('rateds.movie_id', '=', 'recent_movies.movie_id')
            ->where('rateds.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'recent_movies.movie_id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'recent_movies.movie_id')
            ->where('bans.user_id', '=', Auth::user()->id);
        })
        ->select(
            'movies.id',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.original_title as original_title',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        ) */
        ->orderBy('recent_movies.updated_at', 'desc');


        return response()->json([
            'movies' => $movies->get(),
            /* 'series' => $series->get(),
            'series' => $series->get(),
            'series' => $series->get(),
            'series' => $series->get(), */
        ]);
    }
}
