<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MergeController extends Controller
{
    public function pluckId()
    {
        $rateds = DB::table('rateds')
        ->where('user_id', Auth::user()->id)
        ->pluck('movie_id')
        ->toArray();
        $laters = DB::table('laters')
        ->where('user_id', Auth::user()->id)
        ->pluck('movie_id')
        ->toArray();
        $bans = DB::table('bans')
        ->where('user_id', Auth::user()->id)
        ->pluck('movie_id')
        ->toArray();

        $users_movies = array_merge($rateds, $laters, $bans);
        
        $movies = DB::table('movies')
        ->whereIn('movies.id', $users_movies)
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
        ->select(
            'movies.id as movie_id',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        );


        $series_rateds = DB::table('series_rateds')
        ->where('user_id', Auth::user()->id)
        ->pluck('series_id')
        ->toArray();
        $series_laters = DB::table('series_laters')
        ->where('user_id', Auth::user()->id)
        ->pluck('series_id')
        ->toArray();
        $series_bans = DB::table('series_bans')
        ->where('user_id', Auth::user()->id)
        ->pluck('series_id')
        ->toArray();

        $users_series = array_merge($series_rateds, $series_laters, $series_bans);
        
        $series = DB::table('series')
        ->whereIn('series.id', $users_series)
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
        ->select(
            'series.id as movie_idmovie_idmovie_idmovie_id',
            'series_rateds.id as rated_idrated_idrated_idrated_idrated_id',
            'series_rateds.rate as rate_coderate_coderate_coderate_coderate_code',
            'series_laters.id as later_idlater_idlater_idlater_id',
            'series_bans.id as ban_idban_idban_idban_idban_id'
        );


        return response()->json([
            'movies' => $movies->get(),
            'series' => $series->get()
        ]);
    }
}
