<?php

namespace App\Jobs;

use App\Model\Genre;
use App\Model\Movie;
use App\Model\Recommendation;
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
    public function __construct($id, $isWithRecommendation, $check_recent)
    {
        $this->id = $id;
        $this->isWithRecommendation = $isWithRecommendation;
        $this->check_recent = $check_recent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->check_recent){
            $is_recent = Movie::where('id', $this->id)
            ->where('updated_at', '>', Carbon::now()->subHours(30)->toDateTimeString())
            ->first();
            if($is_recent) return;
        }

        if($this->isWithRecommendation){
            $movie = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=en&append_to_response=recommendations%2Csimilar'), true);
            Recommendation::where(['movie_id' => $this->id])->delete();
            for ($k=0; $k < count($movie['similar']['results']); $k++) {
                $temp = $movie['similar']['results'][$k];
                if($temp['vote_count'] < config('constants.suck_page.min_vote_count') || $temp['vote_average'] < config('constants.suck_page.min_vote_average')) continue;
                $recommendation = new Recommendation;
                $recommendation->id = $this->id.'_'.$temp['id'];
                $recommendation->this_id = $temp['id'];
                $recommendation->movie_id = $this->id;
                $recommendation->is_similar = true;
                $recommendation->save();
            }
            for ($k=0; $k < count($movie['recommendations']['results']); $k++) {
                $temp = $movie['recommendations']['results'][$k];
                if($temp['vote_count'] < config('constants.suck_page.min_vote_count') || $temp['vote_average'] < config('constants.suck_page.min_vote_average')) continue;
                Recommendation::updateOrCreate(
                    ['this_id' => $temp['id'], 'movie_id' => $this->id],
                    ['id' => $this->id.'_'.$temp['id'],
                    'is_similar' => false,]
                );
            }
            $movie_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr'), true);
            $movie_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu'), true);
            Movie::updateOrCreate(
                ['id' => $movie['id']],
                ['original_title' => $movie['original_title'],
                'vote_average' => $movie['vote_average'],
                'original_language' => $movie['original_language'],
                'release_date' => new Carbon($movie['release_date']),
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
                'vote_count' => $movie['vote_count']]
            );
            Genre::where(['movie_id' => $this->id])->delete();
            for ($k=0; $k < count($movie['genres']); $k++) { 
                $genre = new Genre;
                $genre->id = $movie['id'].'_'.$movie['genres'][$k]['id'];
                $genre->movie_id = $movie['id'];
                $genre->genre_id = $movie['genres'][$k]['id'];
                $genre->save();
            }
        }else{
            $movie = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=en'), true);
            $movie_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr'), true);
            $movie_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu'), true);
            Movie::updateOrCreate(
                ['id' => $movie['id']],
                ['original_title' => $movie['original_title'],
                'vote_average' => $movie['vote_average'],
                'original_language' => $movie['original_language'],
                'release_date' => new Carbon($movie['release_date']),
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
                'vote_count' => $movie['vote_count']]
            );
            Genre::where(['movie_id' => $this->id])->delete();
            for ($k=0; $k < count($movie['genres']); $k++) { 
                $genre = new Genre;
                $genre->id = $movie['id'].'_'.$movie['genres'][$k]['id'];
                $genre->movie_id = $movie['id'];
                $genre->genre_id = $movie['genres'][$k]['id'];
                $genre->save();
            }
        }
    }
}
