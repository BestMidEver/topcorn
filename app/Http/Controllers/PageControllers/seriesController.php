<?php

namespace App\Http\Controllers\PageControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class seriesController extends Controller
{
    public function series($id, $lang = '', $secondary_lang='')
    {
    	return view('series');
    }
}
