<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Movie\SearchResource;
use App\Model\Movie;
use App\Model\Rated;
use Carbon\Carbon;
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

        $id_dash_title=$id;
    	$id=explode("-", $id)[0];
        if(!is_numeric($id)){
            return redirect('/not-found');
        }else{
            $movie = DB::table('movies')
            ->where('movies.id', '=', $id);
            if($movie->count() > 0){
                $movie = $movie->first();
                $movie_title = $movie->original_title;
                $movie_en_title = $movie->en_title != $movie_title ? $movie->en_title : '';
                $movie_tr_title = $movie->tr_title != $movie_title ? ($movie->tr_title != $movie_en_title ? $movie->tr_title :'') : '';
                $movie_hu_title = $movie->hu_title != $movie_title ? ($movie->hu_title != $movie_en_title ? ($movie->hu_title != $movie_tr_title ? $movie->hu_title :'') :'') : '';
                $movie_year = substr($movie->release_date,0 ,4);
                $poster_path = $movie->en_poster_path;
            }else{
                $movie_title = '';
                $movie_en_title = '';
                $movie_tr_title = '';
                $movie_hu_title = '';
                $movie_year = '';
                $poster_path = '';
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

    	return view('movie', compact('id', 'id_dash_title', 'image_quality', 'target', 'watched_movie_number', 'movie_title', 'movie_en_title', 'movie_tr_title', 'movie_hu_title', 'movie_year', 'poster_path'));
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




    public function get_movie_lists($movie)
    {
        $return_val = DB::table('listes')
        ->leftjoin('listlikes', function ($join) {
            $join->on('listlikes.list_id', '=', 'listes.id');
        })
        ->join('listitems as l0', function ($join) {
            $join->on('l0.list_id', '=', 'listes.id')
            ->where('l0.movie_id', '=', 947);
        })
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
            'm1.'.App::getlocale().'_poster_path as m1_poster_path',
            'm2.'.App::getlocale().'_poster_path as m2_poster_path',
            'm3.'.App::getlocale().'_poster_path as m3_poster_path',
            'm4.'.App::getlocale().'_poster_path as m4_poster_path',
            'm5.'.App::getlocale().'_poster_path as m5_poster_path',
            'm6.'.App::getlocale().'_poster_path as m6_poster_path'
        )
        ->groupBy('listes.id')
        ->orderBy('listes.updated_at', 'desc')
        ->get();

        foreach ($return_val as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        }

        return $return_val;
    }
}
