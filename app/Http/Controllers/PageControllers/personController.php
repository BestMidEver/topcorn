<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class personController extends Controller
{    
	public function person($id, $lang = '')
	{
    	if($lang != '') App::setlocale($lang);
        $id_dash_title=$id;
        $id=explode("-", $id)[0];

        if(Auth::check()){
        	$image_quality = Auth::User()->image_quality;

            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $image_quality = 2;

            $target = '_blank';

            $watched_movie_number = 0;
        }

		return view('person', compact('id', 'id_dash_title', 'image_quality', 'target', 'watched_movie_number'));
	}
}
