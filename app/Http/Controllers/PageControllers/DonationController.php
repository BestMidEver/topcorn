<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DonationController extends Controller
{
	public function donate($lang = '')
	{
		if($lang != '') App::setlocale($lang);

		$image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
        	$watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }


		return view('donation' , compact('image_quality', 'target', 'watched_movie_number'));
	}




    public function change_insta_language($lang)
    {
        if(Auth::check() == 1){
            $user = Auth::User();
            $user->lang = $lang;
            $user->save();
        }else{
            Session::put('insta_language_change_used', $lang);
        }
        return back();
    }




    public function whatmovieshouldiwatch()
    {
        return view('whatmovieshouldiwatch');
    }
}
