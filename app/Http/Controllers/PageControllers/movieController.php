<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Movie\SearchResource;
use App\Model\Movie;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class movieController extends Controller
{
    public function movie($id, $lang = '', $secondary_lang='')
    {
    	if($lang != '') App::setlocale($lang);
    	if($secondary_lang != '') session(['secondary_lang' => $secondary_lang]);

    	$id=explode("-", $id)[0];
        if(!is_numeric($id)){
            return redirect('/not-found');
        }else{
            $movie = DB::table('movies')
            ->where('movies.id', '=', $id);
            if($movie->count() > 0){
                $movie = $movie->first();
                $movie_title = $movie->original_title;
                $movie_year = substr($movie->release_date,0 ,4);
                $movie_plot = $movie->overview;
            }else{
                $movie_title = '';
                $movie_year = '';
                $movie_plot = '';
            }
        }

        $image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }

    	return view('movie', compact('id', 'image_quality', 'target', 'watched_movie_number', 'movie_title', 'movie_year', 'plot'));
    }

    public function get_user_movie_record($movie)
    {
        $return_val = DB::table('movies')
        ->where('movies.id', '=', $movie)
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
        ->leftjoin('recommendations', 'recommendations.this_id', '=', 'movies.id')
        ->leftjoin('rateds as r2', function ($join) {
            $join->on('r2.movie_id', '=', 'recommendations.movie_id')
            ->where('r2.user_id', Auth::user()->id);
        })
        ->select(
            'movies.id as movie_id',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id',
            DB::raw('sum(IF(r2.rate > 0, ABS(r2.rate-3)*(r2.rate-3)*recommendations.is_similar, 0)) AS point'),
            DB::raw('sum(IF(r2.rate > 0, 4*recommendations.is_similar, 0)) as p2'),
            DB::raw('sum(IF(r2.rate > 0, 1, 0)) as count'),
            DB::raw('sum(IF(r2.rate > 0, r2.rate-1, 0))*25 DIV sum(IF(r2.rate > 0, 1, 0)) as percent')
        )
        ->groupBy('movies.id');

        return response()->json($return_val->first());
    }
}
