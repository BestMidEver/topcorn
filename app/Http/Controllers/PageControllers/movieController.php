<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Movie\SearchResource;
use App\Model\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class movieController extends Controller
{
    public function movie($id, $lang = '', $secondary_lang='')
    {
    	if($lang != '') App::setlocale($lang);
    	if($secondary_lang != '') session(['secondary_lang' => $secondary_lang]);

    	$id=explode("-", $id)[0];

        $image_quality = Auth::check() ? Auth::User()->image_quality : 1;

    	return view('movie', compact('id', 'image_quality'));
    }

    public function get_user_movie_record($movie)
    {
        return SearchResource::collection(
            Movie::where('id', $movie)->get()
        );
    }
}
