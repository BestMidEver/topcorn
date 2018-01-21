<?php

namespace App\Http\Controllers\PageControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class homeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
	public function home($lang = '')
	{
    	if($lang != '') App::setlocale($lang);

		return view('home');
	}
}
