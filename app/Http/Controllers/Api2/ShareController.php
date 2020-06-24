<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function getShareObjectModalUsers($type, $objId)
    {
        $return_val = DB::table('follows')
        ->where('follows.object_id', Auth::id())
        ->where('is_deleted', 0)
        ->join('users', 'users.id', 'follows.subject_id')
        ->select(
            'users.id as user_id',
            'users.name as user_name'
        )
        ->orderBy('users.name', 'desc')
        ->get();

        return $return_val;
    }
}
