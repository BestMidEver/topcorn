<?php

namespace App\Jobs;

use App\Jobs\SendNotificationEmailJob;
use App\Jobs\SuckSeriesJob;
use App\Model\Notification;
use App\Model\Review;
use App\Model\Serie;
use App\Model\Series_genre;
use App\Model\Series_later;
use App\Model\Series_network;
use App\Model\Series_recommendation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
        ->where('updated_at', '>', Carbon::now()->subHours(5)->toDateTimeString())
        ->first();
        if($is_recent) return;
        $topcorn_vote_data = DB::table('series_rateds')
        ->where('series_rateds.series_id', '=', $this->id)
        ->where('series_rateds.rate', '>', 0)
        ->select(
            DB::raw('SUM((series_rateds.rate-1)*2.5) as vote_sum'),
            DB::raw('COUNT(series_rateds.series_id) as vote_count')
        )
        ->groupBy('series_rateds.series_id')
        ->first();
        $temp = Serie::where('id', $this->id)->first();
        if($temp) $is_next_episode_defined = $temp->next_episode_air_date == null ? false : true;
        else $is_next_episode_defined = false;
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
            $items = DB::table('users')
                    ->where('users.when_automatic_notification', '>', 0)
                    ->leftjoin('series_laters', function ($join) {
                        $join->on('series_laters.user_id', '=', 'users.id')
                        ->where('series_laters.series_id', '=', $this->id);
                    })
                    ->leftjoin('series_rateds', function ($join) {
                        $join->on('series_rateds.user_id', '=', 'users.id')
                        ->
                        ('series_rateds.series_id', '=', $this->id)
                        ->where('series_rateds.rate', '>', 3);
                    })
                    ->select('users.id as user_id', 'users.when_automatic_notification')
                    ->get();
            if($next_episode_air_date!=null && !$is_next_episode_defined){
                foreach ($items as $item) {
                    $notification = Notification::updateOrCreate(
                        ['mode' => 3, 'user_id' => $item->user_id, 'multi_id' => $this->id],
                        ['is_seen' => 0]
                    );
                    if($item->when_automatic_notification > 1) SendNotificationEmailJob::dispatch($notification->id)->onQueue("high");
                }
            }
            if($next_episode_air_date != null){
                if($next_episode_air_date->diffInDays(Carbon::today()) == 0){
                    foreach ($items as $item) {
                        $old_notification = Notification::where('mode', '=', 7)
                        ->where('user_id', '=', $item->user_id)
                        ->where('multi_id', '=', $this->id)
                        ->first();
                        if($old_notification){
                            $notification_time = new Carbon($old_notification->created_at);
                            if($notification_time->diffInDays(Carbon::now()) > 2){
                                $old_notification->created_at = Carbon::now();
                                $old_notification->is_seen = 0;
                                $old_notification->save();
                                if($item->when_automatic_notification > 1) SendNotificationEmailJob::dispatch($old_notification->id)->onQueue("high");
                            }
                        }else{
                            $notification = Notification::updateOrCreate(
                                ['mode' => 7, 'user_id' => $item->user_id, 'multi_id' => $this->id],
                                ['is_seen' => 0]
                            );
                            if($item->when_automatic_notification > 1) SendNotificationEmailJob::dispatch($notification->id)->onQueue("high");
                        }
                    }
                }
            }
            $last_episode_air_date = null;
            if($series['last_air_date'] != null){$last_episode_air_date = new Carbon($series['last_air_date']);}
            if($topcorn_vote_data){
                $vote_count = $topcorn_vote_data->vote_count+$series['vote_count'];
                $vote_average = ($topcorn_vote_data->vote_sum + $series['vote_average']*$series['vote_count']) / $vote_count;
                $vote_average = round($vote_average, 1);
            }else{
                $vote_count = $series['vote_count'];
                $vote_average = $series['vote_average'];
            }
            Serie::updateOrCreate(
                ['id' => $series['id']],
                ['original_name' => $series['original_name'],
                'vote_average' => $vote_average,
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
                'vote_count' => $vote_count]
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
            for ($k=0; $k < count($series['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 2, 'movie_series_id' => $series['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $series['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $series['reviews']['results'][$k]['author'],
                    'lang' =>  'en',
                    'review' => $series['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($series_tr['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 2, 'movie_series_id' => $series_tr['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $series_tr['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $series_tr['reviews']['results'][$k]['author'],
                    'lang' =>  'tr',
                    'review' => $series_tr['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($series_hu['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 2, 'movie_series_id' => $series_hu['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $series_hu['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $series_hu['reviews']['results'][$k]['author'],
                    'lang' =>  'hu',
                    'review' => $series_hu['reviews']['results'][$k]['content']]
                );
            }
        }else{
            $series = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=en&append_to_response=reviews'), true);
            $series_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=tr&append_to_response=reviews'), true);
            $series_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/tv/'.$this->id.'?api_key='.config('constants.api_key').'&language=hu&append_to_response=reviews'), true);
            $first_air_date = null;
            if($series['first_air_date'] != null){$first_air_date = new Carbon($series['first_air_date']);}
            $next_episode_air_date = null;
            if($series['next_episode_to_air'] != null){
                if($series['next_episode_to_air']['air_date'] != null){$next_episode_air_date = new Carbon($series['next_episode_to_air']['air_date']);}
            }
            $items = DB::table('users')
                    ->leftjoin('series_laters', function ($join) {
                        $join->on('series_laters.user_id', '=', 'users.id')
                        ->where('series_laters.series_id', '=', $this->id);
                    })
                    ->leftjoin('series_rateds', function ($join) {
                        $join->on('series_rateds.user_id', '=', 'users.id')
                        ->where('series_rateds.series_id', '=', $this->id)
                        ->where('series_rateds.rate', '>', 3);
                    })
                    ->whereRaw('(series_laters.id IS NOT NULL OR series_rateds.id IS NOT NULL) AND users.when_automatic_notification > 0')
                    ->select('users.id as user_id', 'users.when_automatic_notification')
                    ->get();
            if($next_episode_air_date!=null && !$is_next_episode_defined){
                foreach ($items as $item) {
                    $notification = Notification::updateOrCreate(
                        ['mode' => 3, 'user_id' => $item->user_id, 'multi_id' => $this->id],
                        ['is_seen' => 0]
                    );
                    if($item->when_automatic_notification > 1) SendNotificationEmailJob::dispatch($notification->id)->onQueue("high");
                }
            }
            if($next_episode_air_date != null){
                if($next_episode_air_date->diffInDays(Carbon::today()) == 0){
                    foreach ($items as $item) {
                        $old_notification = Notification::where('mode', '=', 7)
                        ->where('user_id', '=', $item->user_id)
                        ->where('multi_id', '=', $this->id)
                        ->first();
                        if($old_notification){
                            $notification_time = new Carbon($old_notification->created_at);
                            if($notification_time->diffInDays(Carbon::now()) > 2){
                                $old_notification->created_at = Carbon::now();
                                $old_notification->is_seen = 0;
                                $old_notification->save();
                                if($item->when_automatic_notification > 1) SendNotificationEmailJob::dispatch($old_notification->id)->onQueue("high");
                            }
                        }else{
                            $notification = Notification::updateOrCreate(
                                ['mode' => 7, 'user_id' => $item->user_id, 'multi_id' => $this->id],
                                ['is_seen' => 0]
                            );
                            if($item->when_automatic_notification > 1) SendNotificationEmailJob::dispatch($notification->id)->onQueue("high");
                        }
                    }
                }
            }
            $last_episode_air_date = null;
            if($series['last_air_date'] != null){$last_episode_air_date = new Carbon($series['last_air_date']);}
            if($topcorn_vote_data){
                $vote_count = $topcorn_vote_data->vote_count+$series['vote_count'];
                $vote_average = ($topcorn_vote_data->vote_sum + $series['vote_average']*$series['vote_count']) / $vote_count;
                $vote_average = round($vote_average, 1);
            }else{
                $vote_count = $series['vote_count'];
                $vote_average = $series['vote_average'];
            }
            Serie::updateOrCreate(
                ['id' => $series['id']],
                ['original_name' => $series['original_name'],
                'vote_average' => $vote_average,
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
                'vote_count' => $vote_count]
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
            for ($k=0; $k < count($series['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 2, 'movie_series_id' => $series['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $series['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $series['reviews']['results'][$k]['author'],
                    'lang' =>  'en',
                    'review' => $series['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($series_tr['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 2, 'movie_series_id' => $series_tr['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $series_tr['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $series_tr['reviews']['results'][$k]['author'],
                    'lang' =>  'tr',
                    'review' => $series_tr['reviews']['results'][$k]['content']]
                );
            }
            for ($k=0; $k < count($series_hu['reviews']['results']); $k++) { 
                Review::updateOrCreate(
                    ['mode' => 2, 'movie_series_id' => $series_hu['id'], 'season_number' => null, 'episode_number' => null, 'tmdb_review_id' => $series_hu['reviews']['results'][$k]['id']],
                    ['tmdb_author_name' => $series_hu['reviews']['results'][$k]['author'],
                    'lang' =>  'hu',
                    'review' => $series_hu['reviews']['results'][$k]['content']]
                );
            }
        }
    }
}
