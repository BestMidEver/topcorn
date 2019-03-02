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



    public static function get_popular_lists($mode)
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



    public static function get_popular_reviews($mode)
    {
        $pagination = 24;
        if(Auth::check()){
            $pagination = Auth::User()->pagination;
        }

        $reviews = DB::table('users')
        ->leftjoin('reviews', function ($join) {
            $join->on('reviews.user_id', '=', 'users.id');
        })
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id');
        })
        ->whereNotNull('review_likes.id')
        ->groupBy('reviews.id')
        ->orderBy('count', 'desc');

        if(Auth::check()){
            $reviews = $reviews
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                'r1.rate as rate',
                'reviews.movie_series_id as movie_series_id',
                DB::raw('COUNT(review_likes.id) as count'),
                DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
            );
        }else{
            $reviews = $reviews
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                'r1.rate as rate',
                DB::raw('COUNT(review_likes.id) as count')
            );
        }

        return $reviews->paginate($pagination);
    }



	public function main($lang = '')
	{
    	if($lang != '') App::setlocale($lang);

    	$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();
        
        $users = $this->get_popular_users('commenters');
        $reviews = $this->get_popular_reviews('most liked');

		return view('main', compact('image_quality', 'target', 'watched_movie_number'))->with('users', $users)->with('reviews', $reviews);
	}
}
