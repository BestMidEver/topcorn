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
        ->leftjoin('sent_items', function ($join) use ($type, $objId) {
            $join->on('sent_items.receiver_user_id', 'users.id')
            ->where('sent_items.sender_user_id', Auth::id())
            ->where('sent_items.multi_id', $objId)
            ->where('mode', $type == 'movie' ? 4 : 5);
        })
        ->select(
            'users.id as user_id',
            'users.name as user_name',
            'sent_items.id as sent'
        )
        ->orderBy('users.name', 'desc')
        ->get();

        return $return_val;
    }
}
