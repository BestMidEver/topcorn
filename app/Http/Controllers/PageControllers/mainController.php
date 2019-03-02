<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class mainController extends Controller
{
    public static function get_popular_users($mode)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $users = DB::table('users')
        ->leftjoin('reviews', function ($join) {
            $join->on('reviews.user_id', '=', 'users.id');
        })
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id');
        })
        ->whereNotNull('review_likes.id')
        ->select(
            'users.id as user_id',
            'users.name as name',
            'users.facebook_profile_pic as facebook_profile_path',
            'users.profile_pic as profile_path',
            DB::raw('COUNT(users.id) as count')
        )
        ->groupBy('users.id')
        ->orderBy('count', 'desc');

        return $users->paginate($pagination);
    }



	public function main($lang = '')
	{
    	if($lang != '') App::setlocale($lang);

    	$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        
        $users = $this->get_popular_users('commenters');

		return view('main', compact('image_quality', 'target', 'watched_movie_number'))->with('users', $users);
	}
}
