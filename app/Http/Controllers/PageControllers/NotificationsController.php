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
		$notifications = DB::table('notifications')->paginate(20);
		$return_val = [];
		foreach ($notifications[0]->data as $notification) {
			if($notification->mode == 0){
				$temp = DB::table('reviews')
				->where('reviews.id', '=', $notification->multi_id)
            	->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id')
				->paginate(3);
			}else if($notification->mode == 1){
				$temp = DB::table('listes')
				->where('listes.id', '=', $notification->multi_id)
            	->leftjoin('listlikes', 'listlikes.list_id', '=', 'listes.id')
				->paginate(3);
			}
			array_push($return_val, $temp);
		}
		$notifications = DB::table('notifications')->paginate(20);




		if($lang != '') App::setlocale($lang);

		$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

		return view('notifications', compact('image_quality', 'target', 'watched_movie_number'))->with('notifications', $return_val)->with('paginate_info', $notifications);
    }
}
