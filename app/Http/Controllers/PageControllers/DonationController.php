<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
	public function donate($lang = '')
	{
		if($lang != '') App::setlocale($lang);

		$image_quality = Auth::check() ? Auth::User()->image_quality : 1;

		return view('donation' , compact('image_quality'));
	}
}
