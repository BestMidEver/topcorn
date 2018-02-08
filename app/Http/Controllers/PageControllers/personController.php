<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class personController extends Controller
{    
	public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function person($id, $lang = '')
	{
    	if($lang != '') App::setlocale($lang);

    	$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

		return view('person', compact('id' ,'image_quality', 'target', 'watched_movie_number'));
	}
}
