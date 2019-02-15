<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $fillable = [
    	'mode',
    	'user_id',
    	'multi_id',
    	'is_seen'
    ];

    
    public static function get_notification_button(){
        if(Auth::check()){
            $notifications = DB::table('notifications')
            ->where('notifications.is_seen', '=', 0);

            /*if(Auth::id()!=7) */$notifications = $notifications->where('notifications.user_id', Auth::id());

            $notifications = $notifications->count();

            return $notifications;
        }else return 0;
    }
}