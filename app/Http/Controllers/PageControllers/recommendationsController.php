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
    public function recommendations($user = '')
    {
        if(Auth::check()){
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

        }else{
            $image_quality = 1;
            $target = '_blank';
            $watched_movie_number = 0;
        }


        return view('recommendations', compact('image_quality', 'target', 'watched_movie_number'));
    }

    


    public function get_top_rateds(Request $request)
    {
        $start = microtime(true);

        if(auth::check()){
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
            ->select(
                'movies.id',
                DB::raw('sum(ABS(rateds.rate-3)*(rateds.rate-3)*recommendations.is_similar) AS point'),
                DB::raw('sum(4*recommendations.is_similar) as p2'),
                DB::raw('COUNT(recommendations.this_id) as count'),
                DB::raw('sum(rateds.rate-1)*25 DIV COUNT(movies.id) as percent')
            )
            ->groupBy('movies.id');

            $qqSql = $subq->toSql();

        /////////////////////////////////////////////////////////

            $subq_2 = DB::table('movies')
            ->join(
                DB::raw('(' . $qqSql. ') as ss'),
                function($join) use ($subq) {
                    $join->on('movies.id', '=', 'ss.id')
                    ->addBinding($subq->getBindings());  
                }
            )
            ->rightjoin('movies as m2', 'm2.id', '=', 'movies.id')
            ->select(
                'm2.id',
                'ss.point',
                'ss.count',
                'ss.percent',
                'ss.p2'
            )
            ->where('m2.vote_count', '>', $request->f_vote)
            ->where('m2.vote_average', '>', config('constants.suck_page.min_vote_average'));


            if($request->f_genre != [])
            {
                $subq_2 = $subq_2->join('genres', 'genres.movie_id', '=', 'm2.id')
                ->whereIn('genre_id', $request->f_genre)
                ->groupBy('m2.id')
                ->havingRaw('COUNT(m2.id)='.count($request->f_genre));
            };

            if($request->f_lang != [])
            {
                $subq_2 = $subq_2->whereIn('m2.original_language', $request->f_lang);
            }

            if($request->f_min != 1917)
            {
                $subq_2 = $subq_2->where('m2.release_date', '>=', Carbon::create($request->f_min,1,1));
            }

            if($request->f_max != 2019)
            {
                $subq_2 = $subq_2->where('m2.release_date', '<=', Carbon::create($request->f_max,12,31));
            }

            $qqSql_2 = $subq_2->toSql();

        /////////////////////////////////////////////////////////

            $return_val = DB::table('movies')
            ->join(
                DB::raw('(' . $qqSql_2. ') AS ss'),
                function($join) use ($subq_2) {
                    $join->on('movies.id', '=', 'ss.id')
                    ->addBinding($subq_2->getBindings());  
                }
            )
            ->leftjoin('rateds', function ($join) use ($request) {
                $join->on('rateds.movie_id', '=', 'movies.id')
                ->whereIn('rateds.user_id', $request->f_users);
            })
            ->leftjoin('laters', function ($join) {
                $join->on('laters.movie_id', '=', 'movies.id')
                ->where('laters.user_id', '=', Auth::user()->id);
            })
            ->leftjoin('bans', function ($join) use ($request) {
                $join->on('bans.movie_id', '=', 'movies.id')
                ->whereIn('bans.user_id', $request->f_users);
            })
            ->select(
                'movies.id',
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
                'rateds.id as rated_id',
                'rateds.rate as rate_code',
                'laters.id as later_id',
                'bans.id as ban_id'
            )
            ->groupBy('movies.id');

            if(!$request->f_add_watched){
                $return_val = $return_val->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0 AND sum(IF(bans.id IS NULL, 0, 1)) = 0');
            }

            if($request->f_sort == 'most_popular'){
                $return_val = $return_val->orderBy('movies.popularity', 'desc');
            }else{
                $return_val = $return_val->orderBy('movies.vote_average', 'desc')
                ->orderBy('movies.vote_count', 'desc');
            }


            return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];
        }else{
            $return_val = DB::table('movies')
            ->select(
                'movies.id',
                'movies.original_title as original_title',
                'movies.vote_average',
                'movies.vote_count',
                'movies.release_date',
                'movies.'.App::getlocale().'_title as title',
                'movies.'.App::getlocale().'_poster_path as poster_path'
            )
            ->where('movies.vote_count', '>', 250)
            ->where('movies.vote_average', '>', config('constants.suck_page.min_vote_average'));

            if($request->f_sort == 'most_popular'){
                $return_val = $return_val->orderBy('movies.popularity', 'desc');
            }else{
                $return_val = $return_val->orderBy('movies.vote_average', 'desc')
                ->orderBy('movies.vote_count', 'desc');
            }


            return [$return_val->paginate(24), microtime(true) - $start];
        }
    }

    


    public function get_series_top_rateds()
    {
        $request=new stdClass();
        $request->f_users=[7];



        $start = microtime(true);

        if(auth::check()){
            if(Auth::User()->hover_title_language == 0){
                $hover_name = Auth::User()->secondary_lang.'_name';
            }else{
                $hover_name = 'original_name';
            }

            $subq = DB::table('series_rateds')
            ->whereIn('series_rateds.user_id', $request->f_users)
            ->where('series_rateds.rate', '>', 0)
            ->leftjoin('series_recommendations', 'series_recommendations.series_id', '=', 'series_rateds.series_id')
            ->join('series', 'series.id', '=', 'series_recommendations.this_id')
            ->select(
                'series.id',
                DB::raw('sum(ABS(series_rateds.rate-3)*(series_rateds.rate-3)*series_recommendations.is_similar) AS point'),
                DB::raw('sum(4*series_recommendations.is_similar) as p2'),
                DB::raw('COUNT(series_recommendations.this_id) as count'),
                DB::raw('sum(series_rateds.rate-1)*25 DIV COUNT(series.id) as percent')
            )
            ->groupBy('series.id');

            $qqSql = $subq->toSql();

        /////////////////////////////////////////////////////////

            $subq_2 = DB::table('series')
            ->join(
                DB::raw('(' . $qqSql. ') as ss'),
                function($join) use ($subq) {
                    $join->on('series.id', '=', 'ss.id')
                    ->addBinding($subq->getBindings());  
                }
            )
            ->rightjoin('series as m2', 'm2.id', '=', 'series.id')
            ->select(
                'm2.id',
                'ss.point',
                'ss.count',
                'ss.percent',
                'ss.p2'
            )
            ->where('m2.vote_count', '>', $request->f_vote)
            ->where('m2.vote_average', '>', config('constants.suck_page.min_vote_average'));


            if($request->f_genre != [])
            {
                $subq_2 = $subq_2->join('genres', 'genres.series_id', '=', 'm2.id')
                ->whereIn('genre_id', $request->f_genre)
                ->groupBy('m2.id')
                ->havingRaw('COUNT(m2.id)='.count($request->f_genre));
            };

            if($request->f_lang != [])
            {
                $subq_2 = $subq_2->whereIn('m2.original_language', $request->f_lang);
            }

            if($request->f_min != 1917)
            {
                $subq_2 = $subq_2->where('m2.first_air_date', '>=', Carbon::create($request->f_min,1,1));
            }

            if($request->f_max != 2019)
            {
                $subq_2 = $subq_2->where('m2.first_air_date', '<=', Carbon::create($request->f_max,12,31));
            }

            $qqSql_2 = $subq_2->toSql();

        /////////////////////////////////////////////////////////

            $return_val = DB::table('series')
            ->join(
                DB::raw('(' . $qqSql_2. ') AS ss'),
                function($join) use ($subq_2) {
                    $join->on('series.id', '=', 'ss.id')
                    ->addBinding($subq_2->getBindings());  
                }
            )
            ->leftjoin('series_rateds', function ($join) use ($request) {
                $join->on('series_rateds.series_id', '=', 'series.id')
                ->whereIn('series_rateds.user_id', $request->f_users);
            })
            ->leftjoin('series_laters', function ($join) {
                $join->on('series_laters.series_id', '=', 'series.id')
                ->where('series_laters.user_id', '=', Auth::user()->id);
            })
            ->leftjoin('series_bans', function ($join) use ($request) {
                $join->on('series_bans.series_id', '=', 'series.id')
                ->whereIn('series_bans.user_id', $request->f_users);
            })
            ->select(
                'series.id',
                'series.'.$hover_name.' as original_name',
                'ss.point',
                'ss.count',
                'ss.percent',
                'ss.p2',
                'series.vote_average',
                'series.vote_count',
                'series.first_air_date',
                'series.'.Auth::User()->lang.'_name as name',
                'series.'.Auth::User()->lang.'_poster_path as poster_path',
                'series_rateds.id as rated_id',
                'series_rateds.rate as rate_code',
                'series_laters.id as later_id',
                'series_bans.id as ban_id'
            )
            ->groupBy('series.id');

            if(!$request->f_add_watched){
                $return_val = $return_val->havingRaw('sum(IF(series_rateds.id IS NULL OR series_rateds.rate = 0, 0, 1)) = 0 AND sum(IF(series_bans.id IS NULL, 0, 1)) = 0');
            }

            if($request->f_sort == 'most_popular'){
                $return_val = $return_val->orderBy('series.popularity', 'desc');
            }else{
                $return_val = $return_val->orderBy('series.vote_average', 'desc')
                ->orderBy('series.vote_count', 'desc');
            }


            return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];
        }else{
            $return_val = DB::table('series')
            ->select(
                'series.id',
                'series.original_name as original_name',
                'series.vote_average',
                'series.vote_count',
                'series.first_air_date',
                'series.'.App::getlocale().'_name as name',
                'series.'.App::getlocale().'_poster_path as poster_path'
            )
            ->where('series.vote_count', '>', 250)
            ->where('series.vote_average', '>', config('constants.suck_page.min_vote_average'));

            if($request->f_sort == 'most_popular'){
                $return_val = $return_val->orderBy('series.popularity', 'desc');
            }else{
                $return_val = $return_val->orderBy('series.vote_average', 'desc')
                ->orderBy('series.vote_count', 'desc');
            }


            return [$return_val->paginate(24), microtime(true) - $start];
        }
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
        ->select(
            'recommendations.this_id as id',
            DB::raw('sum(ABS(rateds.rate-3)*(rateds.rate-3)*recommendations.is_similar) AS point'),
            DB::raw('sum(4*recommendations.is_similar) as p2'),
            DB::raw('COUNT(recommendations.this_id) as count'),
            DB::raw('sum(rateds.rate-1)*25 DIV COUNT(movies.id) as percent')
        )
        ->groupBy('movies.id')
        ->havingRaw('sum(rateds.rate-1)*25 DIV COUNT(movies.id) > 74 AND sum(ABS(rateds.rate-3)*(rateds.rate-3)*recommendations.is_similar) > 15*'.count($request->f_users));

        if($request->f_lang != [])
        {
            $subq = $subq->whereIn('original_language', $request->f_lang);
        }

        if($request->f_min != 1917)
        {
            $subq = $subq->where('movies.release_date', '>=', Carbon::create($request->f_min,1,1));
        }

        if($request->f_max != 2019)
        {
            $subq = $subq->where('movies.release_date', '<=', Carbon::create($request->f_max,12,31));
        }

        $qqSql = $subq->toSql();
    ////////////////////////////////////////////////////
        $subq_2 = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq->getBindings());  
            }
        )
        ->leftjoin('rateds', function ($join) use ($request) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->whereIn('rateds.user_id', $request->f_users);
        })
        ->select(
            'ss.id',
            'ss.point',
            'ss.p2',
            'ss.count',
            'ss.percent',
            'rateds.id as rated_id',
            'rateds.rate as rate_code'
        )
        ->groupBy('movies.id');

        if(!$request->f_add_watched){
            $subq_2 = $subq_2->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0');
        }

        $qqSql_2 = $subq_2->toSql();
    ////////////////////////////////////////////////////
        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql_2. ') AS ss'),
            function($join) use ($subq_2) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq_2->getBindings());  
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
        ->select(
            'movies.'.$hover_title.' as original_title',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2',
            'ss.id',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
            'ss.rated_id',
            'ss.rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->where('movies.vote_count', '>', $request->f_vote);

        if($request->f_sort == 'point'){
            $return_val = $return_val->orderBy('point', 'desc')
            ->orderBy('percent', 'desc')
            ->orderBy('vote_average', 'desc');
        }else if($request->f_sort == 'percent'){
            $return_val = $return_val->orderBy('percent', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('vote_average', 'desc');
        }else if($request->f_sort == 'top_rated'){
            $return_val = $return_val->orderBy('vote_average', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('percent', 'desc');
        }else if($request->f_sort == 'most_popular'){
            $return_val = $return_val->orderBy('popularity', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('percent', 'desc');
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




    public function get_momosu(Request $request)
    {
        $start = microtime(true);

        $hover_title = 'original_title';
        $pagination = 24;
        if(Auth::check()){
            if(Auth::User()->hover_title_language == 0)$hover_title = Auth::User()->secondary_lang.'_title';
            $pagination = Auth::User()->pagination;
        } 

        $f_movies = $request->f_mode_movies;
        $f_lang = $request->f_lang;
        $f_min = $request->f_min;
        $f_max = $request->f_max;
        $f_genre = $request->f_genre;
        $f_sort = $request->f_sort;
        $f_vote = $request->f_vote;

        $subq = DB::table('movies')
        ->whereIn('movies.id', $f_movies)
        ->leftjoin('recommendations', 'recommendations.movie_id', '=', 'movies.id')
        ->leftjoin('movies as m2', 'm2.id', '=', 'recommendations.this_id')
        ->groupBy('recommendations.this_id');

        if($f_lang != [])
        {
            $subq = $subq->whereIn('m2.original_language', $f_lang);
        }

        if($f_min != 1917)
        {
            $subq = $subq->where('m2.release_date', '>=', Carbon::create($f_min,1,1));
        }

        if($f_max != 2019)
        {
            $subq = $subq->where('m2.release_date', '<=', Carbon::create($f_max,12,31));
        }

        if(Auth::check()){
            $subq = $subq->leftjoin('rateds', function ($join) {
                $join->on('rateds.movie_id', '=', 'm2.id')
                ->where('rateds.user_id', Auth::id());
            })
            ->select(
                'recommendations.this_id as id',
                DB::raw('sum(recommendations.is_similar) AS point'),
                DB::raw('COUNT(recommendations.this_id) as count'),
                DB::raw('sum(recommendations.is_similar)*20 DIV COUNT(movies.id) as percent'),
                'rateds.id as rated_id',
                'rateds.rate as rate_code'
            );

            if(!$request->f_add_watched){
                $subq = $subq->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0');
            }
        }else{
            $subq = $subq->select(
                'recommendations.this_id as id',
                DB::raw('sum(recommendations.is_similar) AS point'),
                DB::raw('COUNT(recommendations.this_id) as count'),
                DB::raw('sum(recommendations.is_similar)*20 DIV COUNT(movies.id) as percent')
            );
        }

        $qqSql = $subq->toSql();
    ////////////////////////////////////////////////////
        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq->getBindings());  
            }
        )
        ->where('movies.vote_count', '>', $f_vote);

        if(Auth::check()){
            $return_val = $return_val->select(
                'movies.'.$hover_title.' as original_title',
                'ss.id',
                'ss.point',
                'ss.count',
                'ss.percent',
                'movies.vote_average',
                'movies.vote_count',
                'movies.release_date',
                'movies.'.App::getlocale().'_title as title',
                'movies.'.App::getlocale().'_poster_path as poster_path',
                'ss.rated_id',
                'ss.rate_code',
                'laters.id as later_id',
                'bans.id as ban_id'
            )->leftjoin('laters', function ($join) {
                $join->on('laters.movie_id', '=', 'movies.id')
                ->where('laters.user_id', '=', Auth::user()->id);
            })
            ->leftjoin('bans', function ($join) use ($request) {
                $join->on('bans.movie_id', '=', 'movies.id')
                ->where('bans.user_id', Auth::id());
            })
            ->where('bans.id', '=', null);
        }else{
            $return_val = $return_val->select(
                'movies.'.$hover_title.' as original_title',
                'ss.id',
                'ss.point',
                'ss.count',
                'ss.percent',
                'movies.vote_average',
                'movies.vote_count',
                'movies.release_date',
                'movies.'.App::getlocale().'_title as title',
                'movies.'.App::getlocale().'_poster_path as poster_path'
            );
        }

        if($f_sort == 'point'){
            $return_val = $return_val->orderBy('point', 'desc')
            ->orderBy('percent', 'desc')
            ->orderBy('vote_average', 'desc');
        }else if($f_sort == 'percent'){
            $return_val = $return_val->orderBy('percent', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('vote_average', 'desc');
        }else if($f_sort == 'top_rated'){
            $return_val = $return_val->orderBy('vote_average', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('percent', 'desc');
        }else if($f_sort == 'most_popular'){
            $return_val = $return_val->orderBy('popularity', 'desc')
            ->orderBy('point', 'desc')
            ->orderBy('percent', 'desc');
        }

        if($f_genre != [])
        {
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'ss.id')
            ->whereIn('genre_id', $f_genre)
            ->groupBy('movies.id')
            ->havingRaw('COUNT(movies.id)='.count($f_genre));
        }

        return [$return_val->paginate($pagination), microtime(true) - $start];
    }
}
