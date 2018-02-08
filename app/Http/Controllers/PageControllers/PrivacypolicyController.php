<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivacypolicyController extends Controller
{
	public function privacypolicy($lang = '')
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

		return view('privacypolicy' , compact('image_quality', 'target', 'watched_movie_number'));
	}
}
