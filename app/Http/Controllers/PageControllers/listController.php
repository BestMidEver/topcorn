<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Jobs\SuckMovieJob;
use App\Model\Liste;
use App\Model\Listitem;
use App\Model\Listlike;
use App\Model\Notification;
use App\Model\Rated;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class listController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['list'/*, 'anotherMethod'*/]]);
    }




    public function list($id)
    {
        $image_quality = Auth::check() ? Auth::User()->image_quality : 1;
        $hover_title = 'original_title';
        $hover_name = 'original_name';

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }


        $temp = DB::table('listes')
        ->where('listes.id', '=', $id);

        if($temp->count()>0){
            $liste = $temp
            ->join('users', 'users.id', '=', 'user_id')
            ->select(
                    'listes.*',
                    'users.name',
                    'users.id as user_id',
                    DB::raw('IF(users.profile_pic IS NULL OR users.profile_pic = "", users.facebook_profile_pic, CONCAT("'.config('constants.image.thumb_nail')[$image_quality].'", users.profile_pic)) as profile_pic')
                )
            ->get()
            ->toArray();

            $created_at = Carbon::createFromTimeStamp(strtotime($liste[0]->created_at))->diffForHumans();
            $created_at = explode(' ', $created_at);

            $updated_at = Carbon::createFromTimeStamp(strtotime($liste[0]->updated_at))->diffForHumans();
            $updated_at = explode(' ', $updated_at);

            if($liste[0]->visibility == 0 && $liste[0]->user_id != Auth::id()){
                return redirect('/not-found');
            }

            if($liste[0]->sort == 2){
                $order_mode = 'DESC';
            }else if($liste[0]->sort == 0 || $liste[0]->sort == 1){
                $order_mode = 'ASC';
            }

            if(auth::check()){
                $movies = $temp
                ->leftjoin('listitems', 'listitems.list_id', '=', 'listes.id')
                ->leftjoin('movies', 'listitems.movie_id', '=', 'movies.id')
                ->leftjoin('series', 'listitems.movie_id', '=', 'series.id')
                ->leftjoin('rateds', function ($join) {
                    $join->on('rateds.movie_id', '=', 'movies.id')
                    ->where('rateds.user_id', Auth::id())
                    ->where('listitems.mode', '0');
                })
                ->leftjoin('series_rateds', function ($join) {
                    $join->on('series_rateds.series_id', '=', 'series.id')
                    ->where('series_rateds.user_id', Auth::id())
                    ->where('listitems.mode', '1');
                })
                ->leftjoin('laters', function ($join) {
                    $join->on('laters.movie_id', '=', 'movies.id')
                    ->where('laters.user_id', '=', Auth::id())
                    ->where('listitems.mode', '0');
                })
                ->leftjoin('series_laters', function ($join) {
                    $join->on('series_laters.series_id', '=', 'movies.id')
                    ->where('series_laters.user_id', '=', Auth::id())
                    ->where('listitems.mode', '1');
                })
                ->leftjoin('bans', function ($join) {
                    $join->on('bans.movie_id', '=', 'movies.id')
                    ->where('bans.user_id', Auth::id())
                    ->where('listitems.mode', '0');
                })
                ->leftjoin('series_bans', function ($join) {
                    $join->on('series_bans.series_id', '=', 'movies.id')
                    ->where('series_bans.user_id', Auth::id())
                    ->where('listitems.mode', '1');
                })
                ->select(
                    DB::raw('IF(listitems.mode=0, movies.id, series.id) AS id'),
                    'listitems.position',
                    'listitems.explanation',
                    'listitems.mode',
                    DB::raw('IF(listitems.mode=0, movies.'.$hover_title.', series.'.$hover_name.') AS original_title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_title, series.'.App::getlocale().'_name) AS title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_title, series.'.App::getlocale().'_name) AS movie_title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_poster_path, series.'.App::getlocale().'_poster_path) AS poster_path'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_plot, series.'.App::getlocale().'_plot) AS overview'),
                    DB::raw('IF(listitems.mode=0, movies.release_date, series.first_air_date) AS release_date'),
                    DB::raw('IF(listitems.mode=0, rateds.id, series_rateds.id) AS rated_id'),
                    DB::raw('IF(listitems.mode=0, rateds.rate, series_rateds.rate) AS rate_code'),
                    DB::raw('IF(listitems.mode=0, laters.id, series_laters.id) AS later_id'),
                    DB::raw('IF(listitems.mode=0, bans.id, series_bans.id) AS ban_id')
                )
                ->orderBy('listitems.position', $order_mode)
                ->get()
                ->toArray();
            }else{
                $movies = $temp
                ->leftjoin('listitems', 'listitems.list_id', '=', 'listes.id')
                ->leftjoin('movies', 'listitems.movie_id', '=', 'movies.id')
                ->leftjoin('series', 'listitems.movie_id', '=', 'series.id')
                ->select(
                    DB::raw('IF(listitems.mode=0, movies.id, series.id) AS id'),
                    'listitems.position',
                    'listitems.explanation',
                    'listitems.mode',
                    DB::raw('IF(listitems.mode=0, movies.'.$hover_title.', series.'.$hover_name.') AS original_title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_title, series.'.App::getlocale().'_name) AS title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_title, series.'.App::getlocale().'_name) AS movie_title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_poster_path, series.'.App::getlocale().'_poster_path) AS poster_path'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_plot, series.'.App::getlocale().'_plot) AS overview'),
                    DB::raw('IF(listitems.mode=0, movies.release_date, series.first_air_date) AS release_date')
                )
                ->get()
                ->toArray();
            }

            $temp = DB::table('listlikes')
            ->where('listlikes.list_id', '=', $id);

            $like_count = $temp
            ->count();

            $is_liked = $temp
            ->where('listlikes.user_id', '=', Auth::id())
            ->where('listlikes.is_deleted', '=', 0)
            ->count();
        }else{
            return redirect('/not-found');
        }

        return view('list', compact('id', 'image_quality', 'target', 'watched_movie_number', 'liste', 'movies', 'created_at', 'updated_at', 'like_count', 'is_liked'));
    }




    public function create_list($id = 'new')
    {
        $image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

        $hover_title = 'original_title';
        $hover_name = 'original_name';
        
        $id_dash_title = $id;
        $id=explode("-", $id)[0];
        if($id == 'new'){
            $liste = '[]';
            $movies = '[]';
         }else{
            $temp = DB::table('listes')
            ->where('listes.id', '=', $id)
            ->where('listes.user_id', '=', Auth::id());

            if($temp->count()>0){
                $liste = $temp
                ->get()
                ->toArray();

                $movies = $temp
                ->leftjoin('listitems', 'listitems.list_id', '=', 'listes.id')
                ->leftjoin('movies', 'listitems.movie_id', '=', 'movies.id')
                ->leftjoin('series', 'listitems.movie_id', '=', 'series.id')
                ->select(
                    'listitems.movie_id',
                    'listitems.position',
                    'listitems.explanation',
                    'listitems.mode',
                    DB::raw('IF(listitems.mode=0, movies.'.$hover_title.', series.'.$hover_name.') AS original_title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_title, series.'.App::getlocale().'_name) AS movie_title'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_poster_path, series.'.App::getlocale().'_poster_path) AS poster_path'),
                    DB::raw('IF(listitems.mode=0, movies.'.App::getlocale().'_plot, series.'.App::getlocale().'_plot) AS overview'),
                    //'movies.'.$hover_title.' as original_title',
                    //'movies.'.App::getlocale().'_title as movie_title',
                    //'movies.'.App::getlocale().'_poster_path as poster_path',
                    //'movies.'.App::getlocale().'_plot as overview',
                    'movies.release_date'
                )
                ->get()
                ->toArray();
            }else{
                return redirect('/not-found');
            }
        }

        return view('createlist', compact('id', 'id_dash_title', 'image_quality', 'target', 'watched_movie_number', 'liste', 'movies'));
    }




    public function post_createlist(Request $request)
    {

        $request->validate([
            'header' => 'required'
        ]);

        $liste = Liste::updateOrCreate(
            ['user_id' => Auth::id(),
            'id' => $request->list_id],
            ['title' => $request->header,
            'entry_1' => $request->entry_1,
            'entry_2' => $request->entry_2,
            'visibility' => $request->visibility,
            'sort' => $request->sort_by]
        );
        /*return $request->list_id;
        $liste = Liste::where(['user_id' => Auth::id(), 'id' => $request->list_id])->first();
        if(!$liste){
            $liste = new Liste;
            $liste->user_id = Auth::id();
        }
        $liste->title = $request->header;
        $liste->entry_1 = $request->entry_1;
        $liste->entry_2 = $request->entry_2;
        $liste->visibility = $request->visibility;
        $liste->sort = $request->sort_by;

        $liste->save();*/


        $liste->increment('fb_comment_count');

        Listitem::where(['list_id' => $liste->id])->delete();

        $temp = array();
        $temp2 = array();
        $temp3 = array();
        $temp4 = array();
        foreach ($request->items as $index=>$value) {
            if(!in_array( $value[1], $temp2)){
                array_push($temp, $value[0]);
                array_push($temp2, $value[1]);
                $explanation = count($value)>2 ? $value[2]: '';
                array_push($temp3, $explanation);
                array_push($temp4, $value[3]!=1 ? 0:1);
            }
        }
        array_multisort($temp,$temp2,$temp3);
        foreach ($temp2 as $index=>$value) {
            if($value > 0){
                $listitem = new Listitem;
                $listitem->list_id = $liste->id;
                $listitem->mode = $temp4[$index];
                $listitem->movie_id = $value;
                $listitem->position = $index+1;
                $listitem->explanation = $temp3[$index];
                $listitem->save();
                //SuckMovieJob::dispatch($value, false)->onQueue("high");
            }
        }
        $request->session()->flash('status', __('general.list_updated'));


        return redirect('/createlist/'.$liste->id);
    }




    public function delete_list($liste)
    {
        if($liste != 'new'){
            $q = DB::table('listes')
            ->where('listes.user_id', '=', Auth::id())
            ->where('listes.id', '=', $liste);

            if($q->count() > 0){
                $q->delete();
                DB::table('listitems')
                ->where('listitems.list_id', '=', $liste)
                ->delete();
            }
        }
       
        return redirect('/profile/'.Auth::id().'#!#Lists');
    }




    public function like_list($liste)
    {
        $q = DB::table('listes')
        ->where('listes.id', '=', $liste)
        //->where('listes.visibility', '>', 0)
        ->join('users', 'users.id', '=', 'listes.user_id');

        if($q->count() > 0){
            if($q->first()->user_id == Auth::id()) return 'unauthorized';
            $return_val = Listlike::updateOrCreate(
                ['user_id' => Auth::id(),
                'list_id' => $liste],
                ['is_deleted' => 0]
            );

            $list = DB::table('listes')
            ->where('listes.id', $liste)
            ->first();

            if($return_val->wasRecentlyCreated && User::find($list->user_id)->when_user_interaction > 0){
                Notification::updateOrCreate(
                    ['mode' => 1, 'user_id' => $list->user_id, 'multi_id' => $liste],
                    ['is_seen' => 0]
                );
            }
        }

        $like_count = DB::table('listlikes')
        ->where('listlikes.list_id', '=', $liste)
        ->where('listlikes.is_deleted', '=', 0)
        ->count();

        return [$return_val, $like_count];
    }




    public function unlike_list($liste)
    {
        $return_val = Listlike::updateOrCreate(
            ['list_id' => $liste, 'user_id' => Auth::id()],
            ['is_deleted' => 1]
        );

        $will_be_deleted = Notification::where('multi_id', $liste)
        //->where('user_id', Auth::id())
        ->where('mode', 1)
        ->delete();
        
        $like_count = DB::table('listlikes')
        ->where('listlikes.list_id', '=', $liste)
        ->where('listlikes.is_deleted', '=', 0)
        ->count();

        return [$return_val, $like_count];
    }
}
