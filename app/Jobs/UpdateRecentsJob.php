<?php

namespace App\Jobs;

use App\Model\Recent_movie;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRecentsJob implements ShouldQueue
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
        if($this->type === 'movie') {
            /* $movie = Movie::where(['id' => $request->id]);
            if(!$movie->count() > 0) return $response; */
            $recent = Recent_movie::updateOrCreate(array('user_id' => $this->userId, 'movie_id' => $this->objId));
            $recent->touch();
        }
    }
}
