<?php

namespace App\Jobs;

use App\Jobs\SuckMovieJob;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AssignUpdateRecentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $objId;
    protected $userId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $objId, $userId)
    {
        $this->type = $type;
        $this->objId = $objId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->type === 'movie') SuckMovieJob::dispatch($this->objId, false, $this->userId)->onQueue("high");
    }
}
