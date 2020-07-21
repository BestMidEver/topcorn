<?php

namespace App\Http\Controllers\Api2;

use Carbon\Carbon;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    public static function getNotificationButton() {
        return DB::table('notifications')
        ->where('notifications.is_seen', 0)
        ->where('notifications.user_id', Auth::id())
        ->count();
    }

    public static function getNotifications(Request $request) {
        $notifications = DB::table('notifications')
        ->where('user_id', Auth::id())
        ->where('is_seen', 0)
        ->update(array('is_seen' => 1));

        $notifications = DB::table('notifications')
        ->where('notifications.user_id', Auth::id())
        ->select('id', 'multi_id', 'subject_id', 'mode', 'is_seen', 'updated_at')
        ->orderBy('updated_at', 'desc');
        if($request->mode === 'Saved') $notifications = $notifications->where('notifications.is_seen', 2);
        $notifications = $notifications->paginate(Auth::User()->pagination);
        
		foreach ($notifications as $notification) {
			if($notification->mode == 0) {
				$temp = DB::table('reviews')
				->where('reviews.id', $notification->multi_id)
                ->leftjoin('review_likes', 'review_likes.review_id', 'reviews.id')
                ->join('users', 'users.id', 'review_likes.user_id')
                ->where('review_likes.is_deleted', 0);
                return $temp->first()->mode;
				if($temp->first()->mode == 1) {
					$temp = $temp->join('movies', 'movies.id', 'reviews.movie_series_id')
            		->select(
            			'movies.id as obj_id',
            			//'movies.original_title as original_title',
                		'movies.en_title as title',
                        'movies.en_poster_path as poster_path',
                		'movies.release_date as release_date',
                		'users.name as user_name',
                        'users.id as user_id',
                        'users.profile_pic as profile_path',
                        'users.facebook_profile_pic as facebook_profile_path',
                        'reviews.mode as review_mode',
                        'reviews.review',
                		DB::raw('"Review Like Movie" as type')
            		);
				} else if($temp->first()->mode == 3) {
					$temp = $temp->join('series', 'series.id', 'reviews.movie_series_id')
            		->select(
            			'series.id as obj_id',
            			//'series.original_name as original_title',
                        'series.en_name as title',
                        'series.en_poster_path as poster_path',
                		'series.first_air_date as release_date',
                		'users.name as user_name',
                		'users.id as user_id',
                        'users.profile_pic as profile_path',
                        'users.facebook_profile_pic as facebook_profile_path',
                		'reviews.mode as review_mode',
                        'reviews.review',
                        'reviews.season_number',
                        'reviews.episode_number',
                		DB::raw('"Review Like Series" as type')
            		);
                } else if($temp->first()->mode == 4) {
					$temp = $temp->leftjoin('people', 'people.id', 'reviews.movie_series_id')
            		->select(
            			'people.id as obj_id',
                        'people.name',
                        'people.profile_path as poster_path',
                		'users.name as user_name',
                		'users.id as user_id',
                        'users.profile_pic as profile_path',
                        'users.facebook_profile_pic as facebook_profile_path',
                		'reviews.mode as review_mode',
                        'reviews.review',
                		DB::raw('"Review Like Person" as type')
            		);
                }
                $temp = $temp->orderByRaw('IF(users.id = ' . $notification->subject_id . ', 1, 0) DESC');
			}/*  else if($notification->mode == 1) {
				$temp = DB::table('listes')
				->where('listes.id', $notification->multi_id)
            	->leftjoin('listlikes', 'listlikes.list_id', 'listes.id')
                ->where('listlikes.is_deleted', 0)
        		->join('users', 'users.id', 'listlikes.user_id')
        		->select(
        			'listes.id as list_id',
        			'listes.title as title',
            		'users.name as user_name',
            		'users.id as user_id'
        		);
			}  */else if($notification->mode == 2) {
                $temp = DB::table('custom_notifications')
                ->where('custom_notifications.id', $notification->multi_id)
                ->select(
                    'custom_notifications.icon as icon',
                    'custom_notifications.en_notification as notification',
                    DB::raw('"New Feature" as type')
                );
            } else if($notification->mode == 3) {
                $temp = DB::table('series')
                ->where('series.id', $notification->multi_id)
                ->select(
                    'series.id as obj_id',
                    //'series.original_name as original_title',
                    'series.en_name as title',
                    'series.en_poster_path as poster_path',
                    'series.first_air_date as release_date',
                    'series.next_episode_air_date as next_episode_air_date',
                    DB::raw('DATEDIFF(series.next_episode_air_date, NOW()) AS day_difference_next'),
                    DB::raw('"Air Date Changed" as type')
                );
            } else if($notification->mode == 4) {
                $temp = DB::table('notifications')
                ->where('notifications.id', $notification->id)
                ->join('sent_items', 'sent_items.id', 'notifications.multi_id')
                ->join('users', 'users.id', 'sent_items.sender_user_id')
                ->join('movies', 'movies.id', 'sent_items.multi_id')
                ->select(
                    'movies.id as obj_id',
                    //'movies.original_title as original_title',
                    'movies.en_title as title',
                    'movies.en_poster_path as poster_path',
                    'movies.release_date as release_date',
                    'users.name as user_name',
                    'users.id as user_id',
                    'users.profile_pic as profile_path',
                    'users.facebook_profile_pic as facebook_profile_path',
                    DB::raw('"Share Movie" as type')
                );
            } else if($notification->mode == 5) {
                $temp = DB::table('notifications')
                ->where('notifications.id', $notification->id)
                ->join('sent_items', 'sent_items.id', 'notifications.multi_id')
                ->join('users', 'users.id', 'sent_items.sender_user_id')
                ->join('series', 'series.id', 'sent_items.multi_id')
                ->select(
                    'series.id as obj_id',
                    //'series.original_name as original_title',
                    'series.en_name as title',
                    'series.en_poster_path as poster_path',
                    'series.first_air_date as release_date',
                    'users.name as user_name',
                    'users.id as user_id',
                    'users.profile_pic as profile_path',
                    'users.facebook_profile_pic as facebook_profile_path',
                    DB::raw('"Share Series" as type')
                );
            } /* else if($notification->mode == 6) {
                $temp = DB::table('notifications')
                ->where('notifications.id', $notification->id)
                ->join('users', 'users.id', 'notifications.multi_id')
                ->select(
                    'users.name as user_name',
                    'users.id as user_id'
                );
            } */ else if($notification->mode == 7) {
                $temp = DB::table('notifications')
                ->where('notifications.id', $notification->id)
                ->join('series', 'series.id', 'notifications.multi_id')
                ->select(
                    'series.id as obj_id',
                    //'series.original_name as original_title',
                    'series.en_name as title',
                    'series.en_poster_path as poster_path',
                    'notifications.created_at as created_at',
                    DB::raw('DATEDIFF(NOW(), notifications.updated_at) AS day_difference_update'),
                    DB::raw('"Airing Today" as type')
                );
            } else if($notification->mode == 8) {
                $temp = DB::table('notifications')
                ->where('notifications.id', $notification->id)
                ->join('users', 'users.id', 'notifications.multi_id')
                ->join('users as u2', 'u2.id', 'notifications.user_id')
                ->select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'users.profile_pic as profile_path',
                    'users.facebook_profile_pic as facebook_profile_path',
                    'notifications.created_at as created_at',
                    DB::raw('"Started Following" as type')
                );
            }
            $notification->notification = $temp->paginate(1, ['*'], 'page', 1);
            $notification->time_ago = Carbon::createFromTimeStamp(strtotime($notification->updated_at))->diffForHumans(null, true, true);
        }
        return $notifications;
    }

    public static function changeNotificationMode(Request $request) {
        $notification = Notification::where('id', $request->id)->where('user_id', Auth::id())->first();
        $notification->timestamps = false;
        $notification->is_seen = $request->mode;
        $notification->save();

        return Response::make("", 204);
    }
}
