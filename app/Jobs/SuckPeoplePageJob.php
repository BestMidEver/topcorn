<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SuckPeoplePageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $page;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $people = json_decode(file_get_contents('https://api.themoviedb.org/3/person/popular?api_key='.config('constants.api_key').'&language=en-US&page='.$this->page), true)['results'];

        for ($j=0; $j < count($people) ; $j++) {
            SuckPersonJob::dispatch($people[$j]['id'])->onQueue("low");
        }
    }
}
