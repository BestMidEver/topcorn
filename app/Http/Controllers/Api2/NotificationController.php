<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public static function getNotificationButton() {
        return 1;
        $notifications = DB::table('notifications')
        ->where('notifications.is_seen', '=', 0);

        $notifications = $notifications->where('notifications.user_id', Auth::id());

        $notifications = $notifications->count();

        return $notifications;
    }
}
