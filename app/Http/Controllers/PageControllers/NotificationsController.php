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
    public static function get_notification_button(){
        if(Auth::check()){
            $notifications = DB::table('notifications')
            ->where('notifications.is_seen', '=', 0);

            /*if(Auth::id()!=7) */$notifications = $notifications->where('notifications.user_id', Auth::id());

            $notifications = $notifications->count();

            return $notifications;
        }else return 0;
    }




    public function get_notifications($page_mode, $page){
		$notifications = DB::table('notifications')
        ->where('notifications.is_seen', '=', $page_mode=='new'?0:1);

        /*if(Auth::id()!=7) */$notifications = $notifications->where('notifications.user_id', Auth::id());
        
        $notifications = $notifications
        ->select('id', 'multi_id', 'mode', 'is_seen')
        ->orderBy('updated_at', 'desc')
        ->paginate(15, ['*'], 'page', $page);
		$return_val = [];
		foreach ($notifications as $notification) {
			if($notification->mode == 0){
				$temp = DB::table('reviews')
				->where('reviews.id', '=', $notification->multi_id)
        		->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id')
                ->where('review_likes.is_deleted', '=', 0);
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
            }else if($notification->mode == 7){
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('series', 'series.id', '=', 'notifications.multi_id')
                ->select(
                    'series.id as movie_id',
                    'series.original_name as original_title',
                    'series.'.Auth::User()->lang.'_name as title',
                    'notifications.created_at as created_at',
                    DB::raw($notification->is_seen.' as is_seen'),
                    DB::raw($notification->mode.' as notification_mode'),
                    DB::raw($notification->id.' as notification_id')
                )
                ->paginate(1);
            }else if($notification->mode == 8){
                $temp = DB::table('notifications')
                ->where('notifications.id', '=', $notification->id)
                ->join('users', 'users.id', '=', 'notifications.multi_id')
                ->select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'notifications.created_at as created_at',
                    DB::raw($notification->is_seen.' as is_seen'),
                    DB::raw($notification->mode.' as notification_mode'),
                    DB::raw($notification->id.' as notification_id')
                )
                ->paginate(1);
            }
			array_push($return_val, $temp);
		}
        return [$notifications, $return_val];
    }


    public function notifications($id, $lang = '')
    {
        $notification_button = $this->get_notification_button();
        $get_notifications = $this->get_notifications('new', 1);
        $notifications = $get_notifications[0];
        $return_val = $get_notifications[1];

		if($lang != '') App::setlocale($lang);

		$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

		return view('notifications', compact('image_quality', 'target', 'watched_movie_number', 'notification_button'))->with('notifications', $return_val)->with('paginate_info', $notifications);
    }



    public function set_seen($notification_id, $is_seen)
    {
        Notification::where('id', $notification_id)
        ->where('user_id', Auth::id())
        ->update(array('is_seen' => $is_seen));

        return Response([
            'data' => $this->get_notification_button(),
        ], Response::HTTP_CREATED);
    }
}
