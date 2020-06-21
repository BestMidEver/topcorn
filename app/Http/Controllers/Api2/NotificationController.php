<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public static function getNotificationButton() {
        return DB::table('notifications')
        ->where('notifications.is_seen', '=', 0)
        ->where('notifications.user_id', Auth::id())
        ->count();
    }

    public static function getNotifications(Request $request) {
        return $request;
    }
}
