<?php

namespace App\Jobs;

use App\Mail\Recommendation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notification_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification_id)
    {
        $this->notification_id = $notification_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = DB::table('notifications')->where('id', $this->notification_id)->first();

        if($notification){
            if($notification->mode == 2){
                $temp = DB::table('custom_notifications')
                ->where('custom_notifications.id', '=', $notification->multi_id)
                ->select(
                    'custom_notifications.'.Auth::User()->lang.'_notification as notification'
                )
                ->first();

                Mail::to(User::find($notification->user_id))->send(new Feature($temp->notification));
            }else if($notification->mode == 4){
                $temp = DB::table('notifications')
                ->where('notifications.id', '=',  $notification->id)
                ->join('sent_items', 'sent_items.id', '=', 'notifications.multi_id')
                ->join('users', 'users.id', '=', 'sent_items.sender_user_id')
                ->join('movies', 'movies.id', '=', 'sent_items.multi_id')
                ->select('movies.id', 'movies.original_title', 'users.name as user_name')
                ->first();

                Mail::to(User::find($notification->user_id))->send(new Recommendation($temp->original_title, 'movie', $temp->id, $temp->user_name));
            }else if($notification->mode == 5){
                $temp = DB::table('notifications')
                ->where('notifications.id', '=',  $notification->id)
                ->join('sent_items', 'sent_items.id', '=', 'notifications.multi_id')
                ->join('users', 'users.id', '=', 'sent_items.sender_user_id')
                ->join('series', 'series.id', '=', 'sent_items.multi_id')
                ->select('series.id', 'series.original_name', 'users.name as user_name')
                ->first();

                Mail::to(User::find($notification->user_id))->send(new Recommendation($temp->original_name, 'series', $temp->id, $temp->user_name));
            }
        }

    }
}
