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




    public function tt_manipulate(Request $request)
    {
		$user = Auth::User();

    	if($request->column == 'navbar')
        {
            if($user->tt_navbar < $request->level) $user->tt_navbar = $request->level;
        }
        else if($request->column == 'recommendations')
        {
            $user->tt_recommendations = $request->level;
        }
        else if($request->column == 'search')
        {
            $user->tt_search = $request->level;
        }
        else if($request->column == 'quickvote')
        {
            $user->tt_quickvote = $request->level;
        }
        else if($request->column == 'profile')
        {
            $user->tt_profile = $request->level;
        }
        else if($request->column == 'account')
    	{
			$user->tt_account = $request->level;
    	}
    	else
    	{
    		return response("wrong", 405);
    	}

		$user->save();

		return response($user->tt_navbar, 200);
    }  
}
