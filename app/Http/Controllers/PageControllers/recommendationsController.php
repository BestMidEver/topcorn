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
         $start = microtime(true);
         
        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }
        
        $return_val = DB::table('movies')
        ->where('vote_count', '>', Auth::User()->min_vote_count*5)
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

        return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];
    }




    public function get_pemosu(Request $request)
    {
        $start = microtime(true);

        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }

        $subq = DB::table('rateds')
        ->whereIn('rateds.user_id', $request->f_users)
        ->where('rateds.rate', '>', 0)
        ->leftjoin('recommendations', 'recommendations.movie_id', '=', 'rateds.movie_id')
        ->join('movies', 'movies.id', '=', 'recommendations.this_id')
        ->leftjoin('rateds as r2', function ($join) use ($request) {
            $join->on('r2.movie_id', '=', 'movies.id')
            ->whereIn('r2.user_id', $request->f_users);
        })
        ->select(
            'recommendations.this_id as id',
            DB::raw('sum((rateds.rate-3)*recommendations.is_similar) DIV '.count($request->f_users).' AS point'),
            DB::raw('COUNT(recommendations.this_id) as count'),
            DB::raw('sum(rateds.rate)*20 DIV COUNT(recommendations.this_id) as percent'),
            DB::raw('sum(rateds.rate*recommendations.is_similar)*4 DIV COUNT(recommendations.this_id) as p2'),
            'r2.id as rated_id',
            'r2.rate as rate_code'
        )
        ->groupBy('recommendations.this_id')
        ->havingRaw('sum((rateds.rate-3)*recommendations.is_similar) DIV '.count($request->f_users).' > 7 AND sum(rateds.rate)*20 DIV COUNT(recommendations.this_id) > 75 AND sum(IF(r2.id IS NULL OR r2.rate = 0, 0, 1)) = 0');

        if($request->f_lang != [])
        {
            $subq = $subq->whereIn('original_language', $request->f_lang);
        }

        if($request->f_min != 1917)
        {
            $subq = $subq->where('movies.release_date', '>=', Carbon::create($request->f_min,1,1));
        }

        if($request->f_max != 2018)
        {
            $subq = $subq->where('movies.release_date', '<=', Carbon::create($request->f_max,12,31));
        }

        $qqSql = $subq->toSql();



        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq->getBindings());  
            }
        )
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('bans', function ($join) use ($request) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->whereIn('bans.user_id', $request->f_users);
        })
        ->where('bans.id', '=', null)
        /*->rightjoin('movies as m2', 'm2.id', '=', 'movies.id')
        ->orderBy('m2.vote_average', 'desc')*/;

        $tab_mode = 'top_rated';
        if($tab_mode == 'point' || $tab_mode == 'percent' || $tab_mode == 'top_rated')
        {
            $return_val = $return_val->select(
                'ss.id',
                'movies.original_title',
                'movies.'.$hover_title.' as original_title',
                'ss.point',
                'ss.count',
                'ss.percent',
                'ss.p2',
                'movies.vote_average',
                'movies.vote_count',
                'movies.release_date',
                'movies.'.Auth::User()->lang.'_title as title',
                'movies.'.Auth::User()->lang.'_poster_path as poster_path',
                'ss.rated_id',
                'ss.rate_code',
                'laters.id as later_id',
                'bans.id as ban_id'
            );
            if($tab_mode == 'point'){
                $return_val = $return_val->orderBy('point', 'desc')
                ->orderBy('p2', 'desc')
                ->orderBy('vote_average', 'desc');
            }else if($tab_mode == 'percent'){
                $return_val = $return_val->orderBy('p2', 'desc')
                ->orderBy('point', 'desc')
                ->orderBy('vote_average', 'desc');
            }else if($tab_mode == 'top_rated'){
                $return_val = $return_val->orderBy('vote_average', 'desc')
                ->orderBy('point', 'desc')
                ->orderBy('p2', 'desc');
            }
            
        }

        if($request->f_genre != [])
        {
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'ss.id')
            ->whereIn('genre_id', $request->f_genre)
            ->groupBy('movies.id')
            ->havingRaw('COUNT(movies.id)='.count($request->f_genre));
        }
        

        return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];
    }
}
