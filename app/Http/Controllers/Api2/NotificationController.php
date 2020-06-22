<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public static function getNotificationButton() {
        return DB::table('notifications')
        ->where('notifications.is_seen', '=', 0)
        ->where('notifications.user_id', Auth::id())
        ->count();
    }

    public static function getNotifications(Request $request) {
        $notifications = DB::table('notifications')
        ->where('notifications.user_id', Auth::id());
        if($request->mode === 'Saved') $notifications = $notifications->where('notifications.is_seen', 2);
        
        $notifications = $notifications
        ->select('id', 'multi_id', 'mode', 'is_seen')
        ->orderBy('updated_at', 'desc')
        ->paginate(Auth::User()->pagination);

		foreach ($notifications as $notification) {
			if($notification->mode == 0) {
				$temp = DB::table('reviews')
				->where('reviews.id', '=', $notification->multi_id)
        		->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id')
                ->where('review_likes.is_deleted', '=', 0);
				if($temp->first()->mode == 1) {
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
                		'reviews.mode as review_mode'
            		);
				} else if($temp->first()->mode == 3) {
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
                		'reviews.mode as review_mode'
            		);
				}
			} else if($notification->mode == 1) {
				$temp = DB::table('listes')
				->where('listes.id', '=', $notification->multi_id)
            	->leftjoin('listlikes', 'listlikes.list_id', '=', 'listes.id')
                ->where('listlikes.is_deleted', '=', 0)
        		->join('users', 'users.id', '=', 'listlikes.user_id')
        		->select(
        			'listes.id as list_id',
        			'listes.title as title',
            		'users.name as user_name',
            		'users.id as user_id'
        		);
			} else if($notification->mode == 2) {
                $temp = DB::table('custom_notifications')
                ->where('custom_notifications.id', '=', $notification->multi_id)
                ->select(
                    'custom_notifications.icon as icon',
                    'custom_notifications.'.Auth::User()->lang.'_notification as notification'
                );
            } else if($notification->mode == 3) {
                $temp = DB::table('series')
                ->where('series.id', '=', $notification->multi_id)
                ->select(
                    'series.id as movie_id',
                    'series.original_name as original_title',
                    'series.'.Auth::User()->lang.'_name as title',
                    'series.first_air_date as release_date',
                    'series.next_episode_air_date as next_episode_air_date',
                    DB::raw('DATEDIFF(series.next_episode_air_date, NOW()) AS day_difference_next')
                );
            } else if($notification->mode == 4) {
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
                    'users.id as user_id'
                );
            } else if($notification->mode == 5) {
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
                    'users.id as user_id'
                );
            } else if($notification->mode == 6) {
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('users', 'users.id', '=', 'notifications.multi_id')
                ->select(
                    'users.name as user_name',
                    'users.id as user_id'
                );
            } else if($notification->mode == 7) {
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('series', 'series.id', '=', 'notifications.multi_id')
                ->select(
                    'series.id as movie_id',
                    'series.original_name as original_title',
                    'series.'.Auth::User()->lang.'_name as title',
                    'notifications.created_at as created_at'
                );
            } else if($notification->mode == 8) {
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('users', 'users.id', '=', 'notifications.multi_id')
                ->select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'notifications.created_at as created_at'
                );
            }
			$notification->notification = $temp->first();
        }
        return $notifications;
    }
}
