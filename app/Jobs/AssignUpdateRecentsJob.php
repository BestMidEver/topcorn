<?php

namespace App\Jobs;

use App\Jobs\SuckMovieJob;
use App\Jobs\SuckPersonJob;
use App\Jobs\SuckSeriesJob;
use Illuminate\Bus\Queueable;
use App\Jobs\UpdateRecentsJob;
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
        else if($this->type === 'series') SuckSeriesJob::dispatch($this->objId, false, $this->userId)->onQueue("high");
        else if($this->type === 'person') SuckPersonJob::dispatch($this->objId, $this->userId)->onQueue("high");
        else if($this->type === 'user') { if($this->objId != $this->userId) UpdateRecentsJob::dispatch('user', $this->objId, $this->userId)->onQueue("high"); }
        else if($this->type === 'list') UpdateRecentsJob::dispatch('list', $this->objId, $this->userId)->onQueue("high");
    }
}
