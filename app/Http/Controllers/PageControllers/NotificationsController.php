<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Model\Notification;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NotificationsController extends Controller
{
    public function get_notifications($page_mode, $page){
		$notifications = DB::table('notifications')->select('id', 'multi_id', 'mode', 'is_seen')->paginate(5, ['*'], 'page', $page);
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
                		'movies.release_date as release_date',
                		'users.name as user_name',
                		'users.id as user_id',
                		'reviews.mode as review_mode',
                		DB::raw($notification->is_seen.' as is_seen'),
                		DB::raw($notification->mode.' as notification_mode'),
                		DB::raw($notification->id.' as notification_id')
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
                		'series.first_air_date as release_date',
                		'users.name as user_name',
                		'users.id as user_id',
                		'reviews.mode as review_mode',
                		DB::raw($notification->is_seen.' as is_seen'),
                		DB::raw($notification->mode.' as notification_mode'),
                		DB::raw($notification->id.' as notification_id')
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
            		DB::raw($notification->is_seen.' as is_seen'),
            		DB::raw($notification->mode.' as notification_mode'),
            		DB::raw($notification->id.' as notification_id')
        		)
				->paginate(3);
			}else if($notification->mode == 2){
                $temp = DB::table('custom_notifications')
                ->where('custom_notifications.id', '=', $notification->multi_id)
                ->select(
                    'custom_notifications.icon as icon',
                    'custom_notifications.'.Auth::User()->lang.'_notification as notification',
                    DB::raw($notification->is_seen.' as is_seen'),
                    DB::raw($notification->mode.' as notification_mode'),
                    DB::raw($notification->id.' as notification_id')
                )
                ->paginate(1);
            }else if($notification->mode == 3){
                $temp = DB::table('series')
                ->where('series.id', '=', $notification->multi_id)
                ->select(
                    'series.id as movie_id',
                    'series.original_name as original_title',
                    'series.'.Auth::User()->lang.'_name as title',
                    'series.first_air_date as release_date',
                    'series.next_episode_air_date as next_episode_air_date',
                    DB::raw('DATEDIFF(series.next_episode_air_date, NOW()) AS day_difference_next'),
                    DB::raw($notification->is_seen.' as is_seen'),
                    DB::raw($notification->mode.' as notification_mode'),
                    DB::raw($notification->id.' as notification_id')
                )
                ->paginate(1);
            }else if($notification->mode == 4){
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('sent_items', 'sent_items.id', '=', 'notifications.multi_id')
                ->join('users', 'users.id', '=', 'sent_items.sender_user_id')
                ->join('movies', 'movies.id', '=', 'sent_items.multi_id')
                ->select(
                    'movies.id as movie_id',
                    'movies.original_title as original_title',
                    'movies.'.Auth::User()->lang.'_title as title',
                    'movies.release_date as release_date',
                    'users.name as user_name',
                    'users.id as user_id',
                    DB::raw($notification->is_seen.' as is_seen'),
                    DB::raw($notification->mode.' as notification_mode'),
                    DB::raw($notification->id.' as notification_id')
                )
                ->paginate(3);
            }else if($notification->mode == 5){
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('sent_items', 'sent_items.id', '=', 'notifications.multi_id')
                ->join('users', 'users.id', '=', 'sent_items.sender_user_id')
                ->join('series', 'series.id', '=', 'sent_items.multi_id')
                ->select(
                    'series.id as movie_id',
                    'series.original_name as original_title',
                    'series.'.Auth::User()->lang.'_name as title',
                    'series.first_air_date as release_date',
                    'users.name as user_name',
                    'users.id as user_id',
                    DB::raw($notification->is_seen.' as is_seen'),
                    DB::raw($notification->mode.' as notification_mode'),
                    DB::raw($notification->id.' as notification_id')
                )
                ->paginate(3);
            }else if($notification->mode == 6){
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('users', 'users.id', '=', 'notifications.multi_id')
                ->select(
                    'users.name as user_name',
                    'users.id as user_id',
                    DB::raw($notification->is_seen.' as is_seen'),
                    DB::raw($notification->mode.' as notification_mode'),
                    DB::raw($notification->id.' as notification_id')
                )
                ->paginate(3);
            }
			array_push($return_val, $temp);
		}
        return array('notifications' => $notifications, 'return_val' => $return_val);
    }


    public function notifications($id, $lang = '')
    {
        $get_notifications = $this->get_notifications('new', 1)[0];
        $notifications = $get_notifications->notifications;
        $return_val = $get_notifications->return_val;

		if($lang != '') App::setlocale($lang);

		$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

		return view('notifications', compact('image_quality', 'target', 'watched_movie_number'))->with('notifications', $return_val)->with('paginate_info', $notifications);
    }



    public function set_seen($notification_id, $is_seen)
    {
        $notification = Notification::where('id', $notification_id)
        ->where('user_id', Auth::id())
        ->update(array('is_seen' => $is_seen));

        return Response([
            'data' => $notification,
        ], Response::HTTP_CREATED);
    }
}
