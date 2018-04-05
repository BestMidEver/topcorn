<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Liste;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class listController extends Controller
{
    public function list($id)
    {
        $image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }


        return view('list', compact('id', 'image_quality', 'target', 'watched_movie_number'));
    }




    public function createlist($user, $id = 0)
    {
        $image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }


        return view('createlist', compact('id', 'image_quality', 'target', 'watched_movie_number'));
    }




	public function post_createlist(Request $request)
	{

        $request->validate([
            'header' => 'required'
        ]);

        $return_val = DB::table('listitems')
        ->where('user_id', '=', Auth::id())
        ->where('id', '=', $request->list_id);

        if($return_val->count()>0){
            $liste = Liste::where('user_id', '=', Auth::id())
            ->where('id', '=', $request->list_id)
            ->first();
        }else{
            $liste = new Liste;  
        }

        $liste->user_id = 9;
        $liste->save();

        return $request->all();

        /*$user = Auth::User();
        $user->name=$request->name;
        if($request->profile_pic != '? string: ?'){
            if($request->profile_pic == "number:0"){
                $user->profile_pic = '';
            }else{
                $user->profile_pic = '/'.explode("/", $request->profile_pic)[1];
            }
        }
        if($request->cover_pic != '? string: ?'){
            $user->cover_pic = '/'.explode("/", $request->cover_pic)[1];
        }
        if($user->level == 503){
            $user->level = 504;
            $request->session()->flash('tutorial_504', 'level up');
        }
        $user->save();

        $request->session()->flash('status', __('general.info_updated'));


        return redirect('/account');*/
	}
}
