<?php

namespace App\Jobs;

use App\Mail\Recommendation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mode, $user_id, $multi_id)
    {
        $this->mode = $mode;
        $this->user_id = $user_id;
        $this->multi_id = $multi_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(User::find($this->user_id))->send(new Recommendation('memento', 'movie', '77', [2,7]));
    }
}
