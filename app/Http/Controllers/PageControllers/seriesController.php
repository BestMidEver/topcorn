<?php

namespace App\Http\Controllers\PageControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class seriesController extends Controller
{
    public function movie($id, $lang = '', $secondary_lang='')
    {
    	return 5;//view('series');
    }
}
