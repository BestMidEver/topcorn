<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class recommendationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function recommendations($user = '')
    {
        if($user != ''){
            $with_user = User::where(['id' => $user])->first();
            if($with_user){
                Session::flash('with_user_id', $user);
                Session::flash('with_user_name', $with_user->name);
            }
            return redirect('/recommendations');
        }

        $image_quality = Auth::User()->image_quality;

        return view('recommendations', compact('image_quality'));
    }

    


    public function get_top_rateds($tab, Request $request)
    {
        $return_val = DB::table('movies')
        ->where('vote_count', '>', 100)
        ->where('vote_average', '>', config('constants.suck_page.min_vote_average'))
        ->leftjoin('rateds', function ($join) use ($request) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->whereIn('rateds.user_id', $request->f_users);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        //->where('laters.id', '=', null)
        ->leftjoin('bans', function ($join) use ($request) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->whereIn('bans.user_id', $request->f_users);
        })
        ->where('bans.id', '=', null)
        ->select(
            'movies.id as id',
            'movies.original_title',
            'movies.vote_average',
            'movies.release_date',
            'movies.'.$request->lang.'_title as title',
            'movies.'.$request->lang.'_poster_path as poster_path',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->groupBy('movies.id')
        ->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0');

        if($tab=='popular'){
            $return_val = $return_val->orderBy('popularity', 'desc');
        }else{
            $return_val = $return_val->orderBy('vote_average', 'desc');
        }

        if($request->f_genre != []){
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'movies.id')
            ->whereIn('genre_id', $request->f_genre)
            ->havingRaw('COUNT(*)='.count($request->f_genre));
        }

        if($request->f_lang != [])
        {
            $return_val = $return_val->whereIn('original_language', $request->f_lang);
        }

        if($request->f_min != 1917)
        {
            $return_val = $return_val->where('movies.release_date', '>=', Carbon::create($request->f_min,1,1));
        }

        if($request->f_max != 2018)
        {
            $return_val = $return_val->where('movies.release_date', '<=', Carbon::create($request->f_max,12,31));
        }

        return $return_val->paginate(24);
    }




    public function get_pemosu(Request $request)
    {
        $return_val = DB::table('rateds')
        ->whereIn('rateds.user_id', $request->f_users)
        ->where('rateds.rate', '<>', 3)
        ->leftjoin('recommendations', 'recommendations.movie_id', '=', 'rateds.movie_id')
        ->join('movies', 'movies.id', '=', 'recommendations.this_id')
        ->leftjoin('rateds as r2', function ($join) use ($request) {
            $join->on('r2.movie_id', '=', 'movies.id')
            ->whereIn('r2.user_id', $request->f_users);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        //->where('laters.id', '=', null)
        ->leftjoin('bans', function ($join) use ($request) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->whereIn('bans.user_id', $request->f_users);
        })
        ->where('bans.id', '=', null)
        ->select(
            'recommendations.this_id as id',
            'recommendations.movie_id as mother_movie_id',
            'movies.original_title',
            DB::raw('sum(IF(recommendations.is_similar, 1, 7)*(rateds.rate-3.8))*movies.vote_average AS point'),
            DB::raw('COUNT(*) as count'),
            'movies.vote_average',
            'movies.release_date',
            'movies.'.$request->lang.'_title as title',
            'movies.'.$request->lang.'_poster_path as poster_path',
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->groupBy('movies.id')
        ->havingRaw('sum(IF(recommendations.is_similar, 1, 7)*(rateds.rate-3.8)) > 10 AND sum(IF(r2.id IS NULL OR r2.rate = 0, 0, 1)) = 0')
        ->orderBy('point', 'desc');

        if($request->f_genre != [])
        {
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'movies.id')
            ->whereIn('genre_id', $request->f_genre);
        }

        if($request->f_lang != [])
        {
            $return_val = $return_val->whereIn('original_language', $request->f_lang);
        }

        if($request->f_min != 1917)
        {
            $return_val = $return_val->where('movies.release_date', '>=', Carbon::create($request->f_min,1,1));
        }

        if($request->f_max != 2018)
        {
            $return_val = $return_val->where('movies.release_date', '<=', Carbon::create($request->f_max,12,31));
        }

        return $return_val->paginate(24);
    }
}
