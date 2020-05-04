<?php

namespace App\Http\Controllers\Api2;

use App\Model\Recent_movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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


        /* $lists = DB::table('recent_lists')
        ->where('recent_lists.user_id', Auth::user()->id)
        ->leftjoin('listes', 'listes.id', '=', 'recent_lists.list_id')
        ->where('listes.visibility', '=', 1)
        ->leftjoin('listlikes', function ($join) {
            $join->on('listlikes.list_id', '=', 'listes.id');
        })
        ->where('listlikes.is_deleted', '=', 0)
        ->leftjoin('listitems as l1', function ($join) {
            $join->on('l1.list_id', '=', 'listes.id')
            ->where('l1.position', '=', 1);
        })
        ->leftjoin('movies as m1', 'm1.id', '=', 'l1.movie_id')
        ->leftjoin('listitems as l2', function ($join) {
            $join->on('l2.list_id', '=', 'listes.id')
            ->where('l2.position', '=', 2);
        })
        ->leftjoin('movies as m2', 'm2.id', '=', 'l2.movie_id')
        ->leftjoin('listitems as l3', function ($join) {
            $join->on('l3.list_id', '=', 'listes.id')
            ->where('l3.position', '=', 3);
        })
        ->leftjoin('movies as m3', 'm3.id', '=', 'l3.movie_id')
        ->leftjoin('listitems as l4', function ($join) {
            $join->on('l4.list_id', '=', 'listes.id')
            ->where('l4.position', '=', 4);
        })
        ->leftjoin('movies as m4', 'm4.id', '=', 'l4.movie_id')
        ->leftjoin('listitems as l5', function ($join) {
            $join->on('l5.list_id', '=', 'listes.id')
            ->where('l5.position', '=', 5);
        })
        ->leftjoin('movies as m5', 'm5.id', '=', 'l5.movie_id')
        ->leftjoin('listitems as l6', function ($join) {
            $join->on('l6.list_id', '=', 'listes.id')
            ->where('l6.position', '=', 6);
        })
        ->leftjoin('movies as m6', 'm6.id', '=', 'l6.movie_id')
        ->select(
            'listes.id',
            'listes.title',
            DB::raw('COUNT(listlikes.list_id) as like_count'),
            'listes.updated_at',
            DB::raw('LEFT(listes.entry_1 , 50) AS entry_1'),
            DB::raw('LEFT(listes.entry_1 , 51) AS entry_1_raw'),
            'm1.'.App::getlocale().'_cover_path as m1_cover_path',
            'm2.'.App::getlocale().'_cover_path as m2_cover_path',
            'm3.'.App::getlocale().'_cover_path as m3_cover_path',
            'm4.'.App::getlocale().'_cover_path as m4_cover_path',
            'm5.'.App::getlocale().'_cover_path as m5_cover_path',
            'm6.'.App::getlocale().'_cover_path as m6_cover_path'
        )
        ->groupBy('listes.id')
        ->orderBy('listes.updated_at', 'desc'); */


        return response()->json([
            'movies' => $movies->get(),
            'series' => $series->get(),
            'people' => $people->get(),
            'users' => $users->get(),
            //'lists' => $lists->get(),
        ]);
    }

    public function clearRecentlyVisiteds($type)
    {
        $className = ['Recent_movie'];
        if($type === 'movie') $className::where('user_id', $this->userId)->delete();
        return Response::make("", 204);
    }

    public function searchUser($query)
    {
        $return_val = DB::table('users')
        ->where('email', '=', $query)
        ->orwhere('name', 'like', '%' . $query . '%')
        ->select('users.id',
                'users.name',
                'users.profile_pic as profile_path',
                'users.facebook_profile_pic as facebook_profile_path');
        return $return_val->paginate(Auth::User()->pagination);
    }
}
