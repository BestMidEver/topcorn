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
        ->where('recent_movies.user_id', Auth::user()->id)
        ->join('movies', 'movies.id', '=', 'recent_movies.movie_id')
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
        )
        ->orderBy('recent_movies.updated_at', 'desc');


        $series = DB::table('recent_series')
        ->where('recent_series.user_id', Auth::user()->id)
        ->join('series', 'series.id', '=', 'recent_series.series_id')
        ->leftjoin('series_rateds', function ($join) {
            $join->on('series_rateds.series_id', '=', 'recent_series.series_id')
            ->where('series_rateds.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('series_laters', function ($join) {
            $join->on('series_laters.series_id', '=', 'recent_series.series_id')
            ->where('series_laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('series_bans', function ($join) {
            $join->on('series_bans.series_id', '=', 'recent_series.series_id')
            ->where('series_bans.user_id', '=', Auth::user()->id);
        })
        ->select(
            'series.id',
            'series.vote_average',
            'series.vote_count',
            'series.first_air_date',
            'series.original_name as original_name',
            'series.'.Auth::User()->lang.'_name as name',
            'series.'.Auth::User()->lang.'_poster_path as poster_path',
            'series_rateds.id as rated_id',
            'series_rateds.rate as rate_code',
            'series_laters.id as later_id',
            'series_bans.id as ban_id'
        )
        ->orderBy('recent_series.updated_at', 'desc');


        $people = DB::table('recent_people')
        ->where('recent_people.user_id', Auth::user()->id)
        ->join('people', 'people.id', '=', 'recent_people.person_id')
        ->select(
            'people.id',
            'profile_path',
            'name'
        )
        ->orderBy('recent_people.updated_at', 'desc');


        $users = DB::table('recent_users')
        ->where('recent_users.user_id', Auth::user()->id)
        ->join('users', 'users.id', '=', 'recent_users.subject_id')
        ->select(
            'users.id',
            'users.profile_pic as profile_path',
            'users.facebook_profile_pic as facebook_profile_path',
            'users.name'
        )
        ->orderBy('recent_users.updated_at', 'desc');

        return response()->json([
            'movies' => $movies->get(),
            'series' => $series->get(),
            'people' => $people->get(),
            'users' => $users->get(),
        ]);
    }
}
