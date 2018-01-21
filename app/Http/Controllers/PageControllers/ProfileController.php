<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\User;
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

        $user = User::where(['id' => $profile_user_id])->first();
        if(!$user) return redirect('/not-found');
        $profile_user_name = $user->name;
        $profile_cover_pic = $user->cover_pic;
        if($user->profile_pic == ''){
            $profile_profile_pic = $user->facebook_profile_pic;
        }else{
            $profile_profile_pic = config('constants.image.thumb_nail')[$image_quality].$user->profile_pic;
        }

		return view('profile', compact('profile_user_id', 'profile_user_name', 'profile_cover_pic', 'profile_profile_pic', 'image_quality'));
	}    

    public function get_rateds($rate, $user, $lang = 'tr')
    {
        $return_val = DB::table('rateds')
        ->where('rateds.user_id', $user)
        ->join('movies', 'movies.id', '=', 'rateds.movie_id')
        ->leftjoin('laters', function ($join) use ($user) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', $user);
        })
        ->leftjoin('bans', function ($join) use ($user) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->where('bans.user_id', '=', $user);    
        })
        ->select(
            'movies.id as id',
            'movies.'.$lang.'_title as title',
            'movies.original_title as original_title',
            'movies.release_date as release_date',
            'movies.'.$lang.'_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->orderBy('rateds.updated_at', 'desc');

        if($rate=='all'){
            $return_val = $return_val->where('rateds.rate', '<>', 0);
        }else{
            $return_val = $return_val->where('rateds.rate', $rate);
        }

        return $return_val->paginate(24);
    }    

    public function get_laters($user, $lang = 'tr')
    {
        $return_val = DB::table('laters')
        ->where('laters.user_id', $user)
        ->join('movies', 'movies.id', '=', 'laters.movie_id')
        ->leftjoin('rateds', function ($join) use ($user) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->where('rateds.user_id', '=', $user);
        })
        ->leftjoin('bans', function ($join) use ($user) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->where('bans.user_id', '=', $user);
        })
        ->select(
            'movies.id as id',
            'movies.'.$lang.'_title as title',
            'movies.original_title as original_title',
            'movies.release_date as release_date',
            'movies.'.$lang.'_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->orderBy('laters.updated_at', 'desc');

        return $return_val->paginate(24);
    }    

    public function get_bans($user, $lang = 'tr')
    {
        $return_val = DB::table('bans')
        ->where('bans.user_id', $user)
        ->join('movies', 'movies.id', '=', 'bans.movie_id')
        ->leftjoin('rateds', function ($join) use ($user) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->where('rateds.user_id', '=', $user);
        })
        ->leftjoin('laters', function ($join) use ($user) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', $user);
        })
        ->select(
            'movies.id as id',
            'movies.'.$lang.'_title as title',
            'movies.original_title as original_title',
            'movies.release_date as release_date',
            'movies.'.$lang.'_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->orderBy('bans.updated_at', 'desc');

        return $return_val->paginate(24);
    }
}
