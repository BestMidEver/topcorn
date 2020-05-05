<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RateController extends Controller
{
    public function rateAssign(Request $request, $type)
    {
        if($type === 'movie') return $this->rateMovie($request);
    }

    private function rateMovie($request)
    {
        return $request;
    }
}
