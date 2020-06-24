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
        $mode = $type == 'movie' ? 4 : 5;
        $return_val = DB::table('follows')
        ->where('follows.object_id', Auth::id())
        ->where('is_deleted', 0)
        ->join('users', 'users.id', 'follows.subject_id')
        ->leftjoin('sent_items', function ($join) use ($objId, $mode) {
            $join->on('sent_items.receiver_user_id', 'users.id')
            ->where('sent_items.sender_user_id', Auth::id())
            ->where('sent_items.multi_id', $objId)
            ->where('sent_items.mode', $mode);
        })
        ->leftjoin('notifications', function ($join) use ($mode) {
            $join->on('notifications.multi_id', 'sent_items.id')
            ->where('notifications.mode', $mode);
        })
        ->orderBy('users.name', 'asc');
        if($type == 'movie') {
            $return_val = $return_val
            ->leftjoin('rateds', function ($join) use ($objId) {
                $join->on('rateds.user_id', 'follows.subject_id')
                ->where('rateds.movie_id', $objId);
            })
            ->leftjoin('laters', function ($join) use ($objId) {
                $join->on('laters.user_id', 'follows.subject_id')
                ->where('laters.movie_id', $objId);
            })
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.profile_pic as profile_path',
                'users.facebook_profile_pic as facebook_profile_path',
                'sent_items.id as sent',
                'notifications.is_seen',
                'rateds.rate as rate_code',
                'laters.id as later_id'
            );
        } else {
            $return_val = $return_val
            ->leftjoin('series_rateds', function ($join) use ($objId) {
                $join->on('series_rateds.user_id', 'follows.subject_id')
                ->where('series_rateds.series_id', $objId);
            })
            ->leftjoin('series_laters', function ($join) use ($objId) {
                $join->on('series_laters.user_id', 'follows.subject_id')
                ->where('series_laters.series_id', $objId);
            })
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.profile_pic as profile_path',
                'users.facebook_profile_pic as facebook_profile_path',
                'sent_items.id as sent',
                'notifications.is_seen',
                'series_rateds.rate as rate_code',
                'series_laters.id as later_id'
            );
        }

        return $return_val->get();
    }
}
