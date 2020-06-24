<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShareController extends Controller
{
    public function getShareObjectModalUsers($type, $objId)
    {
        return $type;
    }
}
