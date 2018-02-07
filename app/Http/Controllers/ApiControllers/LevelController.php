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

        switch ($request->level) {
        	case 1:
        		$user->level = 1;
        		break;
        	
        	case 100:
        		$user->level = 100;
        		break;
        	
        	case 200:
        		$user->level = 200;
        		break;
        	
        	case 300:
        		$user->level = 300;
        		break;
        	
        	default:
        		return "wrong!";
        }

		$user->save();
		return response($user->level, 200);
    }  
}
