<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscoverController extends Controller
{
    public function discoverAssign(Request $request)
    {
        if($request->type === 'movie') return $request->retrieve === 'All' ? $this->getTopRatedMovies($request) : $this->getPemosuMovies($request);
    }

    private function getTopRatedMovies($request)
    {return $request;
        $start = microtime(true);
    }

    private function getPemosuMovies($request)
    {
        $start = microtime(true);
    }
}
