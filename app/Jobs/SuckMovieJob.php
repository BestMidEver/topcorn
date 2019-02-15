<?php

namespace App\Jobs;

use App\Jobs\SuckMovieJob;
use App\Model\Genre;
use App\Model\Movie;
use App\Model\Recommendation;
use App\Model\Review;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SuckMovieJob implements ShouldQueue
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
        $is_recent = Movie::where('id', $this->id)
        ->where('updated_at', '>', Carbon::now()->subHours(30)->toDateTimeString())
        ->first();
        if($is_recent) return;
        if($this->isWithRecommendation){
            $movie = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=en&append_to_response=recommendations,reviews'), true);
            Recommendation::where(['movie_id' => $this->id])->delete();
            for ($k=0; $k < count($movie['recommendations']['results']); $k++) {
                $temp = $movie['recommendations']['results'][$k];
                SuckMovieJob::dispatch($temp['id'], false)->onQueue("default");
                if($temp['vote_count'] < config('constants.suck_page.min_vote_count') || $temp['vote_average'] < config('constants.suck_page.min_vote_average')) continue;
                Recommendation::updateOrCreate(
                    ['this_id' => $temp['id'], 'movie_id' => $this->id],
                    ['id' => $this->id*10000000 + $temp['id'],
                    'is_similar' => 5-intval($k/4),]
                );
            }
            $movie_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr&append_to_response=reviews'), true);
            $movie_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu&append_to_response=reviews'), true);
            Movie::updateOrCreate(
                ['id' => $movie['id']],
                ['original_title' => $movie['original_title'],
                'vote_average' => $movie['vote_average'],
                'budget' => $movie['budget'],
                'revenue' => $movie['revenue'],
                'original_language' => $movie['original_language'],
                'release_date' => $movie['release_date']!=null ? new Carbon($movie['release_date']) : null,
                'popularity' => $movie['popularity'],
                'en_title' => $movie['title'],
                'tr_title' => $movie_tr['title'],
                'hu_title' => $movie_hu['title'],
                'en_poster_path' => $movie['poster_path'],
                'tr_poster_path' => $movie_tr['poster_path'],
                'hu_poster_path' => $movie_hu['poster_path'],
                'en_cover_path' => $movie['backdrop_path'],
                'tr_cover_path' => $movie_tr['backdrop_path'],
                'hu_cover_path' => $movie_hu['backdrop_path'],
                'en_plot' => $movie['overview'],
                'tr_plot' => $movie_tr['overview'],
                'hu_plot' => $movie_hu['overview'],
                'vote_count' => $movie['vote_count']]
            );
            Genre::where(['movie_id' => $this->id])->delete();
            for ($k=0; $k < count($movie['genres']); $k++) { 
                $genre = new Genre;
                $genre->id = $movie['id']*10000000 + $movie['genres'][$k]['id'];
                $genre->movie_id = $movie['id'];
                $genre->genre_id = $movie['genres'][$k]['id'];
                $genre->save();
            }
            for ($k=0; $k < count($movie['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 0, 'movie_series_id' => $movie['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $movie['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $movie['reviews']['results'][$k]['author'],
                    'lang' =>  'en',
                    'review' => $movie['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($movie_tr['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 0, 'movie_series_id' => $movie_tr['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $movie_tr['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $movie_tr['reviews']['results'][$k]['author'],
                    'lang' =>  'tr',
                    'review' => $movie_tr['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($movie_hu['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 0, 'movie_series_id' => $movie_hu['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $movie_hu['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $movie_hu['reviews']['results'][$k]['author'],
                    'lang' =>  'hu',
                    'review' => $movie_hu['reviews']['results'][$k]['content']]
                );
            }
        }else{
            $movie = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=en&append_to_response=reviews'), true);
            $movie_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr&append_to_response=reviews'), true);
            $movie_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu&append_to_response=reviews'), true);
            Movie::updateOrCreate(
                ['id' => $movie['id']],
                ['original_title' => $movie['original_title'],
                'vote_average' => $movie['vote_average'],
                'budget' => $movie['budget'],
                'revenue' => $movie['revenue'],
                'original_language' => $movie['original_language'],
                'release_date' => $movie['release_date']!=null ? new Carbon($movie['release_date']) : null,
                'popularity' => $movie['popularity'],
                'en_title' => $movie['title'],
                'tr_title' => $movie_tr['title'],
                'hu_title' => $movie_hu['title'],
                'en_poster_path' => $movie['poster_path'],
                'tr_poster_path' => $movie_tr['poster_path'],
                'hu_poster_path' => $movie_hu['poster_path'],
                'en_cover_path' => $movie['backdrop_path'],
                'tr_cover_path' => $movie_tr['backdrop_path'],
                'hu_cover_path' => $movie_hu['backdrop_path'],
                'en_plot' => $movie['overview'],
                'tr_plot' => $movie_tr['overview'],
                'hu_plot' => $movie_hu['overview'],
                'vote_count' => $movie['vote_count']]
            );
            Genre::where(['movie_id' => $this->id])->delete();
            for ($k=0; $k < count($movie['genres']); $k++) { 
                $genre = new Genre;
                $genre->id = $movie['id']*10000000 + $movie['genres'][$k]['id'];
                $genre->movie_id = $movie['id'];
                $genre->genre_id = $movie['genres'][$k]['id'];
                $genre->save();
            }
            for ($k=0; $k < count($movie['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 0, 'movie_series_id' => $movie['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $movie['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $movie['reviews']['results'][$k]['author'],
                    'lang' =>  'en',
                    'review' => $movie['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($movie_tr['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 0, 'movie_series_id' => $movie_tr['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $movie_tr['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $movie_tr['reviews']['results'][$k]['author'],
                    'lang' =>  'tr',
                    'review' => $movie_tr['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($movie_hu['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 0, 'movie_series_id' => $movie_hu['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $movie_hu['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $movie_hu['reviews']['results'][$k]['author'],
                    'lang' =>  'hu',
                    'review' => $movie_hu['reviews']['results'][$k]['content']]
                );
            }
        }
    }
}
