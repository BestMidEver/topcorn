<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatedRequest;
use App\Http\Resources\Rated\RatedResource;
use App\Jobs\SuckMovieJob;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RatedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RatedResource::collection(
            Rated::where(['user_id' => Auth::id()])->get()
        );
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $later = Rated::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->movie_id), array('rate' => $request->rate));
        SuckMovieJob::dispatch($request->movie_id, true)->onQueue("high");
        return Response([
            'data' => new RatedResource($later),
        ], Response::HTTP_CREATED);
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Rated  $rated
     * @return \Illuminate\Http\Response
     */
    public function show(Rated $rated)
    {
        return new RatedResource($rated);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Rated  $rated
     * @return \Illuminate\Http\Response
     */
    public function edit(Rated $rated)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Rated  $rated
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rated $rated)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Rated  $rated
     * @return \Illuminate\Http\Response
     */
    public function destroy($movie)
    {
        $will_be_deleted = Rated::where('id', $movie)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }




    public function get_quick_rate($lang)
    {
        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }

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
            'movies.'.$hover_title.' as original_title',
            DB::raw('COUNT(*) as count'),
            'movies.vote_average',
            'movies.release_date',
            'movies.'.$lang.'_title as title',
            'movies.'.$lang.'_poster_path as poster_path',
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->take(10)->get();

        if($return_val->count()) return $return_val;
        else{
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
                'movies.'.$hover_title.' as original_title',
                'movies.vote_average',
                'movies.release_date',
                'movies.'.$lang.'_title as title',
                'movies.'.$lang.'_poster_path as poster_path',
                'rateds.id as rated_id',
                'rateds.rate as rate_code',
                'laters.id as later_id',
                'bans.id as ban_id'
            )
            ->where('bans.id', '=', null)
            ->inRandomOrder();

            return $return_val->take(50)->get();
        }
        
    }




    public function get_quick_rate_series($lang)
    {
        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_name';
        }else{
            $hover_title = 'original_name';
        }

        $return_val = DB::table('series_rateds')
        ->where('series_rateds.rate', '>', 0)
        ->join('series', 'series.id', '=', 'series_rateds.series_id')
        ->leftjoin('series_rateds as r2', function ($join) {
            $join->on('r2.series_id', '=', 'series.id')
            ->where('r2.user_id', Auth::id());
        })
        ->where('r2.user_id', null)
        ->leftjoin('laters', function ($join) {
            $join->on('laters.series_id', '=', 'series.id')
            ->where('laters.user_id', Auth::id());
        })
        ->where('laters.id', '=', null)
        ->leftjoin('bans', function ($join) {
            $join->on('bans.series_id', '=', 'series.id')
            ->where('bans.user_id', Auth::id());
        })
        ->where('bans.id', '=', null)
        ->groupBy('series.id')
        ->orderBy('count', 'DESC')
        ->select(
            'series.id as id',
            'series.'.$hover_title.' as original_title',
            DB::raw('COUNT(*) as count'),
            'series.vote_average',
            'series.first_air_date',
            'series.'.$lang.'_name as title',
            'series.'.$lang.'_poster_path as poster_path',
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->take(10)->get();

        if($return_val->count()) return $return_val;
        else{
            $return_val = DB::table('series')
            ->leftjoin('series_rateds as series_rateds', function ($join) {
            $join->on('series_rateds.series_id', '=', 'series.id')
            ->where('series_rateds.user_id', Auth::id());
            })
            ->where('series_rateds.user_id', null)
            ->leftjoin('laters', function ($join) {
                $join->on('laters.series_id', '=', 'series.id')
                ->where('laters.user_id', Auth::id());
            })
            ->where('laters.id', '=', null)
            ->leftjoin('bans', function ($join) {
                $join->on('bans.series_id', '=', 'series.id')
                ->where('bans.user_id', Auth::id());
            })
            ->select(
                'series.id as id',
                'series.'.$hover_title.' as original_title',
                'series.vote_average',
                'series.first_air_date',
                'series.'.$lang.'_name as title',
                'series.'.$lang.'_poster_path as poster_path',
                'series_rateds.id as rated_id',
                'series_rateds.rate as rate_code',
                'laters.id as later_id',
                'bans.id as ban_id'
            )
            ->where('bans.id', '=', null)
            ->inRandomOrder();

            return $return_val->take(50)->get();
        }
        
    }




    public function get_watched_movie_number()
    {
        return Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
    }
}
