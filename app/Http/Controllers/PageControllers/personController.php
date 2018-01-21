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

		return view('person', compact('id' ,'image_quality'));
	}
}
