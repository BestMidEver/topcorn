<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
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
            if($user->tt_navbar == 4){ //50 filmden çok oylayanlara navbardaki % tooltipini göstermemek için.
                if(Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count() > 49){
                    $user->tt_navbar = 5;
                }
            }
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
        else if($request->column == 'movie')
    	{
            if($user->tt_movie < $request->level) $user->tt_movie = $request->level;
    	}
    	else
    	{
    		return response("wrong", 405);
    	}

		$user->save();

		return response($request->column, 200);
    }  
}
