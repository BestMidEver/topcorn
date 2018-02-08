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

        $image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }

    	return view('movie', compact('id', 'image_quality', 'target', 'watched_movie_number'));
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
        ->select(
            'movies.id as movie_id',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        );

        return response()->json($return_val->first());
    }
}
