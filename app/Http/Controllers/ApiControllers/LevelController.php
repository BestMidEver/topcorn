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
        return $request->level;
    }  
}
