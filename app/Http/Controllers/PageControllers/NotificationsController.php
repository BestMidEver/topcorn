<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function notifications($id, $lang = '')
    {
		$notifications = DB::table('notifications')->select('multi_id', 'mode', 'is_seen')->paginate(20);
		$return_val = [];
		foreach ($notifications as $notification) {
			if($notification->mode == 0){
				$temp = DB::table('reviews')
				->where('reviews.id', '=', $notification->multi_id)
        		->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id');
				if($temp->first()->mode == 1){
					$temp = $temp
            		->join('movies', 'movies.id', '=', 'reviews.movie_series_id')
            		->join('users', 'users.id', '=', 'review_likes.user_id')
            		->select(
            			'movies.id as movie_id',
            			'movies.original_title as original_title',
                		'movies.'.Auth::User()->lang.'_title as title',
                		'users.name as user_name',
                		'users.id as user_id',
                		'reviews.mode as review_mode',
                		DB::raw($notification->is_seen.' as is_seen')
            		)
					->paginate(3);
				}else if($temp->first()->mode == 3){
					$temp = $temp
            		->join('series', 'series.id', '=', 'reviews.movie_series_id')
            		->join('users', 'users.id', '=', 'review_likes.user_id')
            		->select(
            			'series.id as movie_id',
            			'series.original_name as original_title',
                		'series.'.Auth::User()->lang.'_name as title',
                		'users.name as user_name',
                		'users.id as user_id',
                		'reviews.mode as review_mode',
                		DB::raw($notification->is_seen.' as is_seen')
            		)
					->paginate(3);
				}
			}else if($notification->mode == 1){
				$temp = DB::table('listes')
				->where('listes.id', '=', $notification->multi_id)
            	->leftjoin('listlikes', 'listlikes.list_id', '=', 'listes.id')
        		->join('users', 'users.id', '=', 'listlikes.user_id')
        		->select(
        			'listes.id as list_id',
        			'listes.title as title',
            		'users.name as user_name',
            		'users.id as user_id',
            		DB::raw($notification->is_seen.' as is_seen')
        		)
				->paginate(3);
			}
			array_push($return_val, $temp);
		}




		if($lang != '') App::setlocale($lang);

		$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

		return view('notifications', compact('image_quality', 'target', 'watched_movie_number'))->with('notifications', $return_val)->with('paginate_info', $notifications);
    }
}
