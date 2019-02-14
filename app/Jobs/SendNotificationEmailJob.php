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
            if($notification->mode == 4){
                $movie = DB::table('movies')
                ->where('id', $notification->multi_id)
                ->select('id', 'original_title')
                ->first();
                Mail::to(User::find($notification->user_id))->send(new Recommendation($movie->original_title, 'movie', $movie->id));
            }
        }

    }
}
