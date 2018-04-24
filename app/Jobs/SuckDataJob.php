<?php

namespace App\Jobs;

use App\Jobs\RestartJob;
use App\Jobs\SuckMovieJob;
use App\Jobs\SuckPageJob;
use App\Model\Ban;
use App\Model\Later;
use App\Model\Listitem;
use App\Model\Rated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SuckDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $total_pages = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/popular?api_key='.config('constants.api_key').'&language=en-US&page=1'), true)['total_pages'];
        for ($page=1; $page <= $total_pages; $page++) { 
            SuckPageJob::dispatch($page, true)->onQueue("low");
        }




        $total_pages = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/top_rated?api_key='.config('constants.api_key').'&language=en-US&page=1'), true)['total_pages'];
        for ($page=1; $page <= $total_pages; $page++) {
            SuckPageJob::dispatch($page, false)->onQueue("low");
        }



        
        foreach(Rated::All()->pluck('movie_id')->unique() as $id){
            SuckMovieJob::dispatch($id, true)->onQueue("low");
        }
        foreach(Later::All()->pluck('movie_id')->unique() as $id){
            SuckMovieJob::dispatch($id, false)->onQueue("low");
        }
        foreach(Ban::All()->pluck('movie_id')->unique() as $id){
            SuckMovieJob::dispatch($id, false)->onQueue("low");
        }
        foreach(Listitem::All()->pluck('movie_id')->unique() as $id){
            SuckMovieJob::dispatch($id, false)->onQueue("low");
        }

        //RestartJob::dispatch()->onQueue("low");
    }
}
