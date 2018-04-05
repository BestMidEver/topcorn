<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Liste;
use App\Model\Listitem;
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




    public function createlist($id = 1)
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

        $liste = Liste::updateOrCreate(
            ['user_id' => Auth::id(),
            'id' => $request->list_id],
            ['title' => $request->header,
            'entry_1' => $request->entry_1,
            'entry_2' => $request->entry_2,
            'visibility' => $request->visibility,
            'sort' => $request->sort_by]
        );

        Listitem::where(['list_id' => $liste->id])->delete();

        $temp = array();
        $temp2 = array();
        $temp3 = array();
        foreach ($request->items as $index=>$value) {
            array_push($temp, $value[0]);
            array_push($temp2, $value[1]);
            $explanation = count($value)>2 ? $value[2]: '';
            array_push($temp3, $explanation);
        }
        array_multisort($temp,$temp2,$temp3);
        print_r($temp);
        print_r($temp2);
        print_r($temp3);
        foreach ($temp2 as $index=>$value) {
            if($value > 0){
                $listitem = new Listitem;
                $listitem->list_id = $liste->id;
                $listitem->movie_id = $value;
                $listitem->position = $index;
                $listitem->explanation = $temp3[$index];
                $listitem->save();
            }
        }
        return $request->items;

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
