<?php

namespace App\Jobs;

use App\Jobs\SuckSeriesJob;
use App\Model\Review;
use App\Model\Serie;
use App\Model\Series_genre;
use App\Model\Series_network;
use App\Model\Series_recommendation;
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
        function set_review($series, $lang){
            for ($k=0; $k < count($series['reviews']['results']); $k++) { 
                $review = new Review;
                $review->mode = 2;
                $review->movie_series_id = $series['id'];
                $review->tmdb_author_name = $series['reviews']['results'][$k]['author'];
                $review->tmdb_review_id = $series['reviews']['results'][$k]['id'];
                $review->lang = $lang;
                $review->review = $series['reviews']['results'][$k]['content'];
                $review->save();
            }
        }
        if($this->isWithRecommendation){
            $series = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=en&append_to_response=recommendations,reviews'), true);
            Series_recommendation::where(['series_id' => $this->id])->delete();
            for ($k=0; $k < count($series['recommendations']['results']); $k++) {
                $temp = $series['recommendations']['results'][$k];
                SuckSeriesJob::dispatch($temp['id'], false)->onQueue("default");
                if($temp['vote_count'] < config('constants.suck_page.min_vote_count') || $temp['vote_average'] < config('constants.suck_page.min_vote_average')) continue;
                Series_recommendation::updateOrCreate(
                    ['this_id' => $temp['id'], 'series_id' => $this->id],
                    ['id' => $this->id*10000000 + $temp['id'],
                    'rank' => 5-intval($k/4),]
                );
            }
            $series_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr&append_to_response=reviews'), true);
            $series_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu&append_to_response=reviews'), true);
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
                'first_air_date' => $first_air_date,
                'next_episode_air_date' => $next_episode_air_date,
                'last_episode_air_date' => $last_episode_air_date,
                'popularity' => $series['popularity'],
                'status' => $series['status'],
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
            Series_genre::where(['series_id' => $this->id])->delete();
            for ($k=0; $k < count($series['genres']); $k++) { 
                $genre = new Series_genre;
                $genre->id = $series['id']*10000000 + $series['genres'][$k]['id'];
                $genre->series_id = $series['id'];
                $genre->genre_id = $series['genres'][$k]['id'];
                $genre->save();
            }
            Series_network::where(['series_id' => $this->id])->delete();
            for ($k=0; $k < count($series['networks']); $k++) { 
                $network = new Series_network;
                $network->id = $series['id']*10000000 + $series['networks'][$k]['id'];
                $network->series_id = $series['id'];
                $network->network_id = $series['networks'][$k]['id'];
                $network->save();
            }
            Review::where(['movie_series_id' => $this->id, 'mode' => 2])->delete();
            set_review($series, 'en');
            set_review($series_tr, 'tr');
            set_review($series_hu, 'hu');
        }else{
            $is_recent = Serie::where('id', $this->id)
            ->where('updated_at', '>', Carbon::now()->subHours(5)->toDateTimeString())
            ->first();
            if($is_recent) return;
            
            $series = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=en&append_to_response=reviews'), true);
            $series_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr&append_to_response=reviews'), true);
            $series_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu&append_to_response=reviews'), true);
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
                'first_air_date' => $first_air_date,
                'next_episode_air_date' => $next_episode_air_date,
                'last_episode_air_date' => $last_episode_air_date,
                'popularity' => $series['popularity'],
                'status' => $series['status'],
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
            Series_genre::where(['series_id' => $this->id])->delete();
            for ($k=0; $k < count($series['genres']); $k++) { 
                $genre = new Series_genre;
                $genre->id = $series['id']*10000000 + $series['genres'][$k]['id'];
                $genre->series_id = $series['id'];
                $genre->genre_id = $series['genres'][$k]['id'];
                $genre->save();
            }
            Series_network::where(['series_id' => $this->id])->delete();
            for ($k=0; $k < count($series['networks']); $k++) { 
                $network = new Series_network;
                $network->id = $series['id']*10000000 + $series['networks'][$k]['id'];
                $network->series_id = $series['id'];
                $network->network_id = $series['networks'][$k]['id'];
                $network->save();
            }
            Review::where(['movie_series_id' => $this->id, 'mode' => 2])->delete();
            set_review($series, 'en');
            set_review($series_tr, 'tr');
            set_review($series_hu, 'hu');
        }
    }
}
