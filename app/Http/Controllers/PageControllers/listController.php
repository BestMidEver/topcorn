<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Jobs\SuckMovieJob;
use App\Model\Liste;
use App\Model\Listitem;
use App\Model\Listlike;
use App\Model\Rated;
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

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
            if(Auth::User()->hover_title_language == 0){
                $hover_title = Auth::User()->secondary_lang.'_title';
            }else{
                $hover_title = 'original_title';
            }
        }else{
            $hover_title = 'original_title';
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
                ->join('movies', 'listitems.movie_id', '=', 'movies.id')
                ->leftjoin('rateds', function ($join) {
                    $join->on('rateds.movie_id', '=', 'movies.id')
                    ->where('rateds.user_id', Auth::id());
                })
                ->leftjoin('laters', function ($join) {
                    $join->on('laters.movie_id', '=', 'movies.id')
                    ->where('laters.user_id', '=', Auth::id());
                })
                ->leftjoin('bans', function ($join) {
                    $join->on('bans.movie_id', '=', 'movies.id')
                    ->where('bans.user_id', Auth::id());
                })
                ->select(
                    'listitems.movie_id as id',
                    'listitems.position',
                    'listitems.explanation',
                    'movies.'.$hover_title.' as original_title',
                    'movies.'.App::getlocale().'_title as title',
                    'movies.'.App::getlocale().'_poster_path as poster_path',
                    'movies.'.App::getlocale().'_plot as overview',
                    'movies.release_date',
                    'rateds.id as rated_id',
                    'rateds.rate as rate_code',
                    'laters.id as later_id',
                    'bans.id as ban_id'
                )
                ->orderBy('listitems.position', $order_mode)
                ->get()
                ->toArray();
            }else{
                $movies = $temp
                ->leftjoin('listitems', 'listitems.list_id', '=', 'listes.id')
                ->join('movies', 'listitems.movie_id', '=', 'movies.id')
                ->select(
                    'listitems.id',
                    'listitems.position',
                    'listitems.explanation',
                    'movies.'.$hover_title.' as original_title',
                    'movies.'.App::getlocale().'_title as title',
                    'movies.'.App::getlocale().'_poster_path as poster_path',
                    'movies.'.App::getlocale().'_plot as overview',
                    'movies.release_date'
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

        if(Auth::User()->hover_title_language == 0){
            $hover_title = Auth::User()->secondary_lang.'_title';
        }else{
            $hover_title = 'original_title';
        }

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
                ->join('movies', 'listitems.movie_id', '=', 'movies.id')
                ->select(
                    'listitems.movie_id',
                    'listitems.position',
                    'listitems.explanation',
                    'movies.'.$hover_title.' as original_title',
                    'movies.'.App::getlocale().'_title as movie_title',
                    'movies.'.App::getlocale().'_poster_path as poster_path',
                    'movies.'.App::getlocale().'_plot as overview',
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
        foreach ($request->items as $index=>$value) {
            if(!in_array( $value[1], $temp2)){
                array_push($temp, $value[0]);
                array_push($temp2, $value[1]);
                $explanation = count($value)>2 ? $value[2]: '';
                array_push($temp3, $explanation);
            }
        }
        array_multisort($temp,$temp2,$temp3);
        return $temp2;
        foreach ($temp2 as $index=>$value) {
            if($value > 0){
                $listitem = new Listitem;
                $listitem->list_id = $liste->id;
                $listitem->movie_id = $value;
                $listitem->position = $index+1;
                $listitem->explanation = $temp3[$index];
                $listitem->save();
                SuckMovieJob::dispatch($value, false)->onQueue("high");
            }
        }
        $request->session()->flash('status', __('general.list_updated'));

        
        //return redirect('/createlist/'.$liste->id);
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
        ->where('listes.visibility', '>', 0);

        if($q->count() > 0){
            $return_val = Listlike::updateOrCreate(
                ['user_id' => Auth::id(),
                'list_id' => $liste],
                []
            );
        }

        $like_count = DB::table('listlikes')
        ->where('listlikes.list_id', '=', $liste)
        ->count();

        return [$return_val, $like_count];
    }




    public function unlike_list($liste)
    {
        $q = DB::table('listes')
        ->leftjoin('listlikes', 'listes.id', '=', 'listlikes.list_id')
        ->where('listes.id', '=', $liste)
        ->where('listes.visibility', '>', 0);

        if($q->count() > 0){
            $return_val = Listlike::where(['list_id' => $liste, 'user_id' => Auth::id()])->delete();
        }
        
        $like_count = DB::table('listlikes')
        ->where('listlikes.list_id', '=', $liste)
        ->count();

        return [$return_val, $like_count];
    }
}
