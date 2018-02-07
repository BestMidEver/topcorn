<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function level_manipulate(Request $request)
    {
		$user = Auth::User();

    	$accepted_modes = [1,100,101,200,201,300,301,400,401,500,600];
    	if(in_array($request->level, $accepted_modes))
    	{
			$user->level = $request->level;
    	}
    	else
    	{
    		return response("wrong", 405);
    	}


		$user->save();
		return response($user->level, 200);
    }  
}
