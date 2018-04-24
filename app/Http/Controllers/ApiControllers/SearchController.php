<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Movie\SearchResource;
use App\Model\Movie;
use App\Model\Partie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $return_val = DB::table('listes')
        ->where('listes.title', 'like', '%' . $text . '%')
        ->where('listes.visibility', '=', 1)
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
        ->groupBy('listes.id')
        ->orderBy('listes.updated_at', 'desc')
        ->paginate(12);
return $return_val[0];
        foreach ($return_val->data as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        }

        return $return_val;
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
