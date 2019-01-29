<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class seriesController extends Controller
{
    public function series($id, $lang = '', $secondary_lang='')
    {
    	$image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
            $rated_id = 'null';
            $rate_code = 'null';
            $later_id = 'null';
            $ban_id = 'null';
            $point = 'null';
            $p2 = 'null';
            $count = 'null';
            $percent = 'null';
        }

        $id_dash_name=$id;
        $id=explode("-", $id)[0];
        if(!is_numeric($id)){
            return redirect('/not-found');
        }else{
            $series = DB::table('series')
            ->where('series.id', '=', $id);
            if($series->count() > 0){
                $series = $series->first();
                $series_name = $series->original_name;
                $series_en_name = $series->en_name != $series_name ? $series->en_name : '';
                $series_tr_name = $series->tr_name != $series_name ? ($series->tr_name != $series_en_name ? $series->tr_name :'') : '';
                $series_hu_name = $series->hu_name != $series_name ? ($series->hu_name != $series_en_name ? ($series->hu_name != $series_tr_name ? $series->hu_name :'') :'') : '';
                $series_year = substr($series->first_air_date, 0 ,4);
                $poster_path = $series->en_poster_path;
            }else{
                $series_name = '';
                $series_en_name = '';
                $series_tr_name = '';
                $series_hu_name = '';
                $series_year = '';
                $poster_path = '';
            }
            $temp = DB::table('series')
            ->where('series.id', '=', $id)
            ->leftjoin('series_rateds', function ($join) {
                $join->on('series_rateds.series_id', '=', 'series.id')
                ->where('series_rateds.user_id', '=', Auth::user()->id);
            })
            ->leftjoin('series_laters', function ($join) {
                $join->on('series_laters.series_id', '=', 'series.id')
                ->where('series_laters.user_id', '=', Auth::user()->id);
            })
            ->leftjoin('series_bans', function ($join) {
                $join->on('series_bans.series_id', '=', 'series.id')
                ->where('series_bans.user_id', '=', Auth::user()->id);
            })
            ->leftjoin('series_recommendations', 'series_recommendations.this_id', '=', 'series.id')
            ->leftjoin('series_rateds as r2', function ($join) {
                $join->on('r2.series_id', '=', 'series_recommendations.series_id')
                ->where('r2.user_id', Auth::user()->id);
            })
            ->leftjoin('series_seens', 'series_seens.series_id', '=', 'series.id')
            ->select(
                'series.id as series_id',
                'series_rateds.id as rated_id',
                'series_rateds.rate as rate_code',
                'series_laters.id as later_id',
                'series_bans.id as ban_id',
                'series_seens.id as last_seen_id',
                'series_seens.season_number as last_seen_season',
                'series_seens.episode_number as last_seen_episode',
                DB::raw('sum(IF(r2.rate > 0, ABS(r2.rate-3)*(r2.rate-3)*series_recommendations.rank, 0)) AS point'),
                DB::raw('sum(IF(r2.rate > 0, 4*series_recommendations.rank, 0)) as p2'),
                DB::raw('sum(IF(r2.rate > 0, 1, 0)) as count'),
                DB::raw('sum(IF(r2.rate > 0, r2.rate-1, 0))*25 DIV sum(IF(r2.rate > 0, 1, 0)) as percent')
            )
            ->groupBy('series.id');
            if($temp->count() > 0){
                $temp = $temp->first();
                $rated_id = $temp->rated_id==''?'null':$temp->rated_id;
                $rate_code = $temp->rate_code==''?'null':$temp->rate_code;
                $later_id = $temp->later_id==''?'null':$temp->later_id;
                $ban_id = $temp->ban_id==''?'null':$temp->ban_id;
                $point = $temp->point==''?'null':$temp->point;
                $p2 = $temp->p2==''?'null':$temp->p2;
                $count = $temp->count==''?'null':$temp->count;
                $percent = $temp->percent==''?'null':$temp->percent;
                $last_seen_id = $temp->last_seen_id==''?'null':$temp->last_seen_id;
                $last_seen_season = $temp->last_seen_season==''?'null':$temp->last_seen_season;
                $last_seen_episode = $temp->last_seen_episode==''?'null':$temp->last_seen_episode;
            }else{
                $rated_id = 'null';
                $rate_code = 'null';
                $later_id = 'null';
                $ban_id = 'null';
                $point = 'null';
                $p2 = 'null';
                $count = 'null';
                $percent = 'null';
                $last_seen_id = 'null';
                $last_seen_season = 'null';
                $last_seen_episode = 'null';
            }
        }

    	return view('series', compact('id', 'id_dash_name', 'image_quality', 'target', 'watched_movie_number', 'series_name', 'series_en_name', 'series_tr_name', 'series_hu_name', 'series_year', 'series_path', 'rated_id', 'rate_code', 'later_id', 'ban_id', 'point', 'p2', 'count', 'percent', 'last_seen_id', 'last_seen_season', 'last_seen_episode', 'poster_path'));
    }
}
