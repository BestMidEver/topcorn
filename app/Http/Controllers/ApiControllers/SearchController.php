<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Movie\SearchResource;
use App\Model\Movie;
use App\Model\Partie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    


    
    public function get_last_parties()
    {
        $return_val = DB::table('parties')
    	->where('user_id', '=', Auth::user()->id)
    	->orderBy('parties.updated_at', 'desc')
    	->leftjoin('users', 'users.id', '=', 'parties.watched_with_user_id')
    	->select('users.id as user_id',
                'users.name as name',
                'users.profile_pic as profile_path',
                'users.facebook_profile_pic as facebook_profile_path');
        return $return_val->paginate(12);
    }




    public function search_users($text = null)
    {
        $return_val = DB::table('users')
        ->where('email', '=', $text)
        ->orwhere('name', 'like', '%' . $text . '%')
        ->select('users.id as user_id',
                'users.name as name',
                'users.profile_pic as profile_path',
                'users.facebook_profile_pic as facebook_profile_path');
        return $return_val->paginate(12);
    }




    public function search_lists($text)
    {
        return $text;
    }




    public function remove_from_parties($user_id)
    {
    	return DB::table('parties')
    	->where('user_id', '=', Auth::user()->id)
    	->where('watched_with_user_id', '=', $user_id)
    	->delete();
    }




    public function add_to_parties($user_id)
    {
    	return Partie::updateOrCreate(
    		['user_id' => Auth::user()->id, 'watched_with_user_id' => $user_id]
    	)->touch() ? 1 : 0;
    }




    public function get_pluck_id()
    {
        $rateds = DB::table('rateds')
        ->where('user_id', Auth::user()->id)
        ->pluck('movie_id')
        ->toArray();
        $laters = DB::table('laters')
        ->where('user_id', Auth::user()->id)
        ->pluck('movie_id')
        ->toArray();
        $bans = DB::table('bans')
        ->where('user_id', Auth::user()->id)
        ->pluck('movie_id')
        ->toArray();

        $users_movies = array_merge($rateds, $laters, $bans);
        
        $return_val = DB::table('movies')
        ->whereIn('movies.id', $users_movies)
        ->leftjoin('rateds', function ($join) {
            $join->on('rateds.movie_id', '=', 'movies.id')
            ->where('rateds.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', Auth::user()->id);
        })
        ->leftjoin('bans', function ($join) {
            $join->on('bans.movie_id', '=', 'movies.id')
            ->where('bans.user_id', '=', Auth::user()->id);
        })
        ->select(
            'movies.id as movie_id',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        );

        return $return_val->get();
    }
}
