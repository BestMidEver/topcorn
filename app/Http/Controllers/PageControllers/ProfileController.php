<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
	public function profile($profile_user_id, $lang = '')
	{
		if($lang != '') App::setlocale($lang);

        $image_quality = Auth::check() ? Auth::User()->image_quality : 1;

        if(Auth::check()){
            $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';
            $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '>', 0)->count();
        }else{
            $target = '_self';
            $watched_movie_number = null;
        }
        $profile_watched_movie_number = Rated::where('user_id', $profile_user_id)->where('rate', '>', 0)->count();

        $user = User::where(['id' => $profile_user_id])->first();
        if(!$user) return redirect('/not-found');
        $profile_user_name = $user->name;
        $profile_cover_pic = $user->cover_pic;
        $facebook_link = $user->facebook_link;
        $instagram_link = $user->instagram_link;
        $twitter_link = $user->twitter_link;
        $youtube_link = $user->youtube_link;
        $another_link_url = $user->another_link_url;
        $another_link_name = $user->another_link_name;
        if($user->profile_pic == ''){
            $profile_profile_pic = $user->facebook_profile_pic;
        }else{
            $profile_profile_pic = config('constants.image.thumb_nail')[$image_quality].$user->profile_pic;
        }

        $list_number = DB::table('listes')
        ->where('listes.user_id', '=', $profile_user_id)
        ->count();

        $like_number = DB::table('listes')
        ->where('listes.user_id', '=', $profile_user_id)
        ->leftjoin('listlikes', function ($join) {
            $join->on('listlikes.list_id', '=', 'listes.id');
        })
        ->whereNotNull('listlikes.created_at')
        ->count();

		return view('profile', compact('profile_user_id', 'profile_user_name', 'profile_cover_pic', 'profile_profile_pic', 'image_quality', 'target', 'watched_movie_number', 'profile_watched_movie_number', 'list_number', 'like_number', 'facebook_link', 'instagram_link', 'twitter_link', 'youtube_link', 'another_link_url', 'another_link_name'));
	}

    public function get_rateds($rate, $user, $lang)
    {
        if(Auth::check()){
            if(Auth::User()->hover_title_language == 0){
                $hover_title = Auth::User()->secondary_lang.'_title';
            }else{
                $hover_title = 'original_title';
            }
            $pagin=Auth::User()->pagination;
        }else{
            $hover_title = 'original_title';
            $pagin=24;
        }

        $return_val = DB::table('rateds')
        ->where('rateds.user_id', $user)
        ->join('movies', 'movies.id', '=', 'rateds.movie_id')
        ->leftjoin('rateds as r2', function ($join) {
            $join->on('r2.movie_id', '=', 'movies.id')
            ->where('r2.user_id', Auth::id());
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::id());
        })
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->where('bans.user_id', '=', Auth::id());    
        })
        ->select(
            'movies.id as id',
            'movies.'.$lang.'_title as title',
            'movies.'.$hover_title.' as original_title',
            'movies.release_date as release_date',
            'movies.'.$lang.'_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'movies.vote_count as vote_count',
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->orderBy('rateds.updated_at', 'desc');

        if($rate=='all'){
            $return_val = $return_val->where('rateds.rate', '<>', 0);
        }else{
            $return_val = $return_val->where('rateds.rate', $rate);
        }

        return $return_val->paginate($pagin);
    }




    public function get_laters($user, $lang)
    {
        if(Auth::check()){
            if(Auth::User()->hover_title_language == 0){
                $hover_title = Auth::User()->secondary_lang.'_title';
            }else{
                $hover_title = 'original_title';
            }
            $pagin=Auth::User()->pagination;
        }else{
            $hover_title = 'original_title';
            $pagin=24;
        }

        $return_val = DB::table('laters')
        ->where('laters.user_id', $user)
        ->join('movies', 'movies.id', '=', 'laters.movie_id')
        ->leftjoin('rateds', function ($join) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->where('rateds.user_id', '=', Auth::id());
        })
        ->leftjoin('laters as l2', function ($join) {
            $join->on('l2.movie_id', '=', 'movies.id')
            ->where('l2.user_id', Auth::id());
        })
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->where('bans.user_id', '=', Auth::id());
        })
        ->select(
            'movies.id as id',
            'movies.'.$lang.'_title as title',
            'movies.'.$hover_title.' as original_title',
            'movies.release_date as release_date',
            'movies.'.$lang.'_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'movies.vote_count as vote_count',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'l2.id as later_id',
            'bans.id as ban_id'
        )
        ->orderBy('laters.updated_at', 'desc');

        return $return_val->paginate($pagin);
    }




    public function get_bans($user, $lang)
    {
        if(Auth::check()){
            if(Auth::User()->hover_title_language == 0){
                $hover_title = Auth::User()->secondary_lang.'_title';
            }else{
                $hover_title = 'original_title';
            }
            $pagin=Auth::User()->pagination;
        }else{
            $hover_title = 'original_title';
            $pagin=24;
        }

        $return_val = DB::table('bans')
        ->where('bans.user_id', $user)
        ->join('movies', 'movies.id', '=', 'bans.movie_id')
        ->leftjoin('rateds', function ($join) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->where('rateds.user_id', '=', Auth::id());
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::id());
        })
        ->leftjoin('bans as b2', function ($join) {
            $join->on('b2.movie_id', '=', 'movies.id')
            ->where('b2.user_id', Auth::id());
        })
        ->select(
            'movies.id as id',
            'movies.'.$lang.'_title as title',
            'movies.'.$hover_title.' as original_title',
            'movies.release_date as release_date',
            'movies.'.$lang.'_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'movies.vote_count as vote_count',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'b2.id as ban_id'
        )
        ->orderBy('bans.updated_at', 'desc');

        return $return_val->paginate($pagin);
    }




    public function get_lists($list_mode, $user)
    {
        $return_val = DB::table('listes')
        ->leftjoin('listlikes', function ($join) {
            $join->on('listlikes.list_id', '=', 'listes.id');
        })
        ->leftjoin('listitems as l1', function ($join) {
            $join->on('l1.list_id', '=', 'listes.id')
            ->where('l1.position', '=', 1);
        })
        ->leftjoin('movies as m1', 'm1.id', '=', 'l1.movie_id')
        ->leftjoin('listitems as l2', function ($join) {
            $join->on('l2.list_id', '=', 'listes.id')
            ->where('l2.position', '=', 2);
        })
        ->leftjoin('movies as m2', 'm2.id', '=', 'l2.movie_id')
        ->leftjoin('listitems as l3', function ($join) {
            $join->on('l3.list_id', '=', 'listes.id')
            ->where('l3.position', '=', 3);
        })
        ->leftjoin('movies as m3', 'm3.id', '=', 'l3.movie_id')
        ->leftjoin('listitems as l4', function ($join) {
            $join->on('l4.list_id', '=', 'listes.id')
            ->where('l4.position', '=', 4);
        })
        ->leftjoin('movies as m4', 'm4.id', '=', 'l4.movie_id')
        ->leftjoin('listitems as l5', function ($join) {
            $join->on('l5.list_id', '=', 'listes.id')
            ->where('l5.position', '=', 5);
        })
        ->leftjoin('movies as m5', 'm5.id', '=', 'l5.movie_id')
        ->leftjoin('listitems as l6', function ($join) {
            $join->on('l6.list_id', '=', 'listes.id')
            ->where('l6.position', '=', 6);
        })
        ->leftjoin('movies as m6', 'm6.id', '=', 'l6.movie_id')
        ->select(
            'listes.id',
            'listes.title',
            DB::raw('COUNT(listlikes.list_id) as like_count'),
            'listes.updated_at',
            DB::raw('LEFT(listes.entry_1 , 50) AS entry_1'),
            DB::raw('LEFT(listes.entry_1 , 51) AS entry_1_raw'),
            'm1.'.App::getlocale().'_poster_path as m1_poster_path',
            'm2.'.App::getlocale().'_poster_path as m2_poster_path',
            'm3.'.App::getlocale().'_poster_path as m3_poster_path',
            'm4.'.App::getlocale().'_poster_path as m4_poster_path',
            'm5.'.App::getlocale().'_poster_path as m5_poster_path',
            'm6.'.App::getlocale().'_poster_path as m6_poster_path'
        )
        ->groupBy('listes.id');

        if($list_mode == 'created_ones'){
            $return_val = $return_val
            ->where('listes.user_id', $user)
            ->orderBy('listes.updated_at', 'desc');
        }else{
            $return_val = $return_val
            ->leftjoin('listlikes as lili2', function ($join) {
                $join->on('lili2.list_id', '=', 'listes.id');
            })
            ->where('lili2.user_id', $user)
            ->orderBy('lili2.updated_at', 'desc');
        }

        if(Auth::check()){
            if($user != Auth::id()){
                $return_val = $return_val
                ->where('listes.visibility', 1);
            }
        }

        $return_val = $return_val->get();

        foreach ($return_val as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        }

        return $return_val;
    }




    public function get_series_laters($mode, $user, $lang)
    {
        if(Auth::check()){
            if(Auth::User()->hover_title_language == 0){
                $hover_name = Auth::User()->secondary_lang.'_name';
            }else{
                $hover_name = 'original_name';
            }
            $pagin=Auth::User()->pagination;
        }else{
            $hover_name = 'original_name';
            $pagin=24;
        }

        $return_val = DB::table('series_laters')
        ->where('series_laters.user_id', $user)
        ->join('series', 'series.id', '=', 'series_laters.series_id')
        ->leftjoin('series_seens', function ($join) {
            $join->on('series_seens.series_id', '=', 'series.id')
            ->where('series_seens.user_id', '=', Auth::id());
        })
        ->leftjoin('series_rateds', function ($join) {
            $join->on('series_rateds.series_id', '=', 'series.id')
            ->where('series_rateds.user_id', '=', Auth::id());
        })
        ->leftjoin('series_laters as l2', function ($join) {
            $join->on('l2.series_id', '=', 'series.id')
            ->where('l2.user_id', Auth::id());
        })
        ->leftjoin('series_bans', function ($join) {
            $join->on('series_bans.series_id', '=', 'series.id')
            ->where('series_bans.user_id', '=', Auth::id());
        })
        ->select(
            'series.id as id',
            'series.'.$lang.'_name as name',
            'series.'.$hover_name.' as original_name',
            'series_seens.next_season as next_season',
            'series_seens.next_episode as next_episode',
            'series.first_air_date as first_air_date',
            'series.last_episode_air_date as last_episode_air_date',
            'series.next_episode_air_date as next_episode_air_date',
            'series.status as status',
            'series_seens.air_date as last_seen_air_date',
            DB::raw('DATEDIFF(series.last_episode_air_date, series_seens.air_date) AS day_difference_last'),
            DB::raw('DATEDIFF(series.next_episode_air_date, NOW()) AS day_difference_next'),
            'series.'.$lang.'_poster_path as poster_path',
            'series.vote_average as vote_average',
            'series.vote_count as vote_count',
            'series_rateds.id as rated_id',
            'series_rateds.rate as rate_code',
            'l2.id as later_id',
            'series_bans.id as ban_id'
        );

        if($mode == 'unseen'){
            $return_val = $return_val
            ->whereNull('series_seens.air_date')
            ->whereNotNull('series.last_episode_air_date')
            ->orderBy('series_seens.updated_at', 'desc');
        }else if($mode == 'available'){
            $return_val = $return_val
            ->whereRaw('(DATEDIFF(series.last_episode_air_date, series_seens.air_date) > 0) OR (DATEDIFF(series.next_episode_air_date, NOW()) < 0)')
            ->orderBy('series_seens.updated_at', 'desc');
        }else if($mode == 'awaited'){
            $return_val = $return_val
            ->whereRaw('DATEDIFF(series.last_episode_air_date, series_seens.air_date) = 0')
            ->orderBy('day_difference_next', 'desc');
        }

        return $return_val->paginate($pagin);
    }




    public function get_series_rateds($rate, $user, $lang)
    {
        if(Auth::check()){
            if(Auth::User()->hover_title_language == 0){
                $hover_name = Auth::User()->secondary_lang.'_name';
            }else{
                $hover_name = 'original_name';
            }
            $pagin=Auth::User()->pagination;
        }else{
            $hover_name = 'original_name';
            $pagin=24;
        }

        $return_val = DB::table('series_rateds')
        ->where('series_rateds.user_id', $user)
        ->join('series', 'series.id', '=', 'series_rateds.series_id')
        ->leftjoin('series_rateds as r2', function ($join) {
            $join->on('r2.series_id', '=', 'series.id')
            ->where('r2.user_id', Auth::id());
        })
        ->leftjoin('series_laters', function ($join) {
            $join->on('series_laters.series_id', '=', 'series.id')
            ->where('series_laters.user_id', '=', Auth::id());
        })
        ->leftjoin('series_bans', function ($join) {
            $join->on('series_bans.series_id', '=', 'series.id')
            ->where('series_bans.user_id', '=', Auth::id());    
        })
        ->select(
            'series.id as id',
            'series.'.$lang.'_name as name',
            'series.'.$hover_name.' as original_name',
            'series.first_air_date as first_air_date',
            'series.'.$lang.'_poster_path as poster_path',
            'series.vote_average as vote_average',
            'series.vote_count as vote_count',
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'series_laters.id as later_id',
            'series_bans.id as ban_id'
        )
        ->orderBy('series_rateds.updated_at', 'desc');

        if($rate=='all'){
            $return_val = $return_val->where('series_rateds.rate', '<>', 0);
        }else{
            $return_val = $return_val->where('series_rateds.rate', $rate);
        }

        return $return_val->paginate($pagin);
    }




    public function get_series_bans($user, $lang)
    {
        if(Auth::check()){
            if(Auth::User()->hover_title_language == 0){
                $hover_name = Auth::User()->secondary_lang.'_name';
            }else{
                $hover_name = 'original_name';
            }
            $pagin=Auth::User()->pagination;
        }else{
            $hover_name = 'original_name';
            $pagin=24;
        }

        $return_val = DB::table('series_bans')
        ->where('series_bans.user_id', $user)
        ->join('series', 'series.id', '=', 'series_bans.series_id')
        ->leftjoin('series_rateds', function ($join) {
            $join->on('series_rateds.series_id', '=', 'series.id')
            ->where('series_rateds.user_id', '=', Auth::id());
        })
        ->leftjoin('series_laters', function ($join) {
            $join->on('series_laters.series_id', '=', 'series.id')
            ->where('series_laters.user_id', '=', Auth::id());
        })
        ->leftjoin('series_bans as b2', function ($join) {
            $join->on('b2.series_id', '=', 'series.id')
            ->where('b2.user_id', Auth::id());
        })
        ->select(
            'series.id as id',
            'series.'.$lang.'_name as name',
            'series.'.$hover_name.' as original_name',
            'series.first_air_date as first_air_date',
            'series.'.$lang.'_poster_path as poster_path',
            'series.vote_average as vote_average',
            'series.vote_count as vote_count',
            'series_rateds.id as rated_id',
            'series_rateds.rate as rate_code',
            'series_laters.id as later_id',
            'b2.id as ban_id'
        )
        ->orderBy('series_bans.updated_at', 'desc');

        return $return_val->paginate($pagin);
    }
}
