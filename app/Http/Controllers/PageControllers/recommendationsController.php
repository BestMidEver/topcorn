<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
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

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

        return view('recommendations', compact('image_quality', 'target', 'watched_movie_number'));
    }

    


    public function get_top_rateds($tab, Request $request)
    {
        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }
        
        $return_val = DB::table('movies')
        ->where('vote_count', '>', 20)
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
            'movies.'.$hover_title.' as original_title',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
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
        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }

        $return_val = DB::table('rateds')
        ->whereIn('rateds.user_id', $request->f_users)
        ->where('rateds.rate', '>', 0)
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
            //'recommendations.movie_id as mother_movie_id',
            'movies.'.$hover_title.' as original_title',
            DB::raw('sum((rateds.rate-3)*recommendations.is_similar) AS point'),
            DB::raw('COUNT(movies.id) as count'),
            DB::raw('sum(rateds.rate)*20 DIV COUNT(movies.id) as percent'),
            DB::raw('sum(rateds.rate*recommendations.is_similar)*4 DIV COUNT(movies.id) as p2'),
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->groupBy('movies.id')
        ->havingRaw('sum((rateds.rate-3)*recommendations.is_similar) > 9 AND sum(rateds.rate)*20 DIV COUNT(movies.id) > 70 AND sum(IF(r2.id IS NULL OR r2.rate = 0, 0, 1)) = 0')
        ->orderBy('point', 'desc')
        ->orderBy('p2', 'desc');

        if($request->f_genre != []){
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
