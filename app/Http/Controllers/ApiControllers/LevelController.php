<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




    public function level_manipulate(Request $request)
    {
        switch ($request->level) {
        	case 1:
        		$user = Auth::User();
        		$user->level = 1;
        		$user->save();
        		return "bu birdir";
        		break;
        	
        	case 100:
        		return "bu yüzdür";
        		break;
        	
        	default:
        		return "wrong!";
        }
    }  
}
