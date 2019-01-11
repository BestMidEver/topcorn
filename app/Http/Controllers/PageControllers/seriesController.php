<?php

namespace App\Http\Controllers\PageControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class seriesController extends Controller
{
    public function series($id, $lang = '', $secondary_lang='')
    {
    	if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }

    	return view('series', compact('id'));
    }
}
