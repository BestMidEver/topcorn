<?php

namespace App\Jobs;

use App\Model\Serie;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SuckSeriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $isWithRecommendation;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $isWithRecommendation)
    {
        $this->id = $id;
        $this->isWithRecommendation = $isWithRecommendation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $is_recent = Serie::where('id', $this->id)
        ->where('updated_at', '>', Carbon::now()->subHours(30)->toDateTimeString())
        ->first();
        if($is_recent) return;

        if($this->isWithRecommendation){
        }else{
            $series = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=en'), true);
            $series_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr'), true);
            $series_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu'), true);
            $first_air_date = null;
            if($series['first_air_date'] != null){$first_air_date = new Carbon($series['first_air_date']);}
            $next_episode_air_date = null;
            if($series['next_episode_to_air'] != null){
                if($series['next_episode_to_air']['air_date'] != null){$next_episode_air_date = new Carbon($series['next_episode_to_air']['air_date']);}
            }
            $last_episode_air_date = null;
            if($series['last_air_date'] != null){$last_episode_air_date = new Carbon($series['last_air_date']);}
            Serie::updateOrCreate(
                ['id' => $series['id']],
                ['original_name' => $series['original_name'],
                'vote_average' => $series['vote_average'],
                'original_language' => $series['original_language'],
                'first_air_date' => $first_air_date),
                'next_episode_air_date' => $next_episode_air_date),
                'last_episode_air_date' => $last_episode_air_date),
                'popularity' => $series['popularity'],
                'en_name' => $series['name'],
                'tr_name' => $series_tr['name'],
                'hu_name' => $series_hu['name'],
                'en_poster_path' => $series['poster_path'],
                'tr_poster_path' => $series_tr['poster_path'],
                'hu_poster_path' => $series_hu['poster_path'],
                'en_backdrop_path' => $series['backdrop_path'],
                'tr_backdrop_path' => $series_tr['backdrop_path'],
                'hu_backdrop_path' => $series_hu['backdrop_path'],
                'en_plot' => $series['overview'],
                'tr_plot' => $series_tr['overview'],
                'hu_plot' => $series_hu['overview'],
                'vote_count' => $series['vote_count']]
            );
            /*Genre::where(['movie_id' => $this->id])->delete();
            for ($k=0; $k < count($series['genres']); $k++) { 
                $genre = new Genre;
                $genre->id = $series['id']*10000000 + $series['genres'][$k]['id'];
                $genre->movie_id = $series['id'];
                $genre->genre_id = $series['genres'][$k]['id'];
                $genre->save();
            }*/
        }
    }
}
