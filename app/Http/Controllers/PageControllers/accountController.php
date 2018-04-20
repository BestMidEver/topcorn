<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Picture\TrPictureResource;
use App\Model\Rated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class accountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




	public function account($lang = '')
	{
		if($lang != '') App::setlocale($lang);

		$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

        $list_number = DB::table('listes')
        ->where('listes.user_id', '=', Auth::id())
        ->count();

        $like_number = DB::table('listes')
        ->where('listes.user_id', '=', Auth::id())
        ->leftjoin('listlikes', function ($join) {
            $join->on('listlikes.list_id', '=', 'listes.id');
        })
        ->whereNotNull('listlikes.created_at')
        ->count();

        $exploded_url = explode("://", Auth::User()->another_link_url);
        $url_http = $exploded_url[0].'://';
        $another_link_url = count($exploded_url) > 1 ? $exploded_url[1] : '';

		return view('account', compact('image_quality', 'target', 'watched_movie_number', 'list_number', 'like_number', 'url_http', 'another_link_url'));
	}




	public function change_profile(Request $request)
	{
		$request->validate([
			'name' => 'required|min:6',
		]);

		$user = Auth::User();
		$user->name=$request->name;
		if($request->profile_pic != '? string: ?'){
			if($request->profile_pic == "number:0"){
				$user->profile_pic = '';
			}else{
				$user->profile_pic = '/'.explode("/", $request->profile_pic)[1];
			}
		}
		if($request->cover_pic != '? string: ?'){
			$user->cover_pic = '/'.explode("/", $request->cover_pic)[1];
		}
		$user->facebook_link = $request->facebook_link;
		$user->twitter_link = $request->twitter_link;
		$user->instagram_link = $request->instagram_link;
		$user->youtube_link = $request->youtube_link;
		$user->another_link_name = $request->another_link_name;
		$user->another_link_url = $request->another_link_url ? $request->url_http.$request->another_link_url : null;
		$user->save();

		$request->session()->flash('status', __('general.info_updated'));


		return redirect('/account');
	}

	


	public function password($lang = '')
	{
    	if($lang != '') App::setlocale($lang);

    	$is_from_facebook=0;
		if(Auth::User()->facebook_id){
			if(Hash::check(Auth::User()->facebook_id+config('constants.facebook.password_spice'), Auth::User()->password)){
				$is_from_facebook = 1;
			}
		}

		$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

		return view('accountpassword', compact('is_from_facebook', 'image_quality', 'target', 'watched_movie_number'));
	}




	public function change_password(Request $request, $lang = '')
	{	
		if($lang != '') App::setlocale($lang);

		if(Hash::check(Auth::User()->facebook_id, Auth::User()->password)){

			$request->validate([
	            'new_password' => 'required|confirmed|min:6',
			]);
			$user = Auth::User();
			$user->password = Hash::make($request->new_password);
			$user->save();

			$request->session()->flash('status', __('general.pw_updated'));

			return redirect('/account/password');

		}else if(Hash::check($request->current_password, Auth::User()->password)){

			$request->validate([
				'current_password' => 'required|min:6',
	            'new_password' => 'required|confirmed|min:6',
			]);
			$user = Auth::User();
			$user->password = Hash::make($request->new_password);
			$user->save();

			$request->session()->flash('status', __('general.pw_updated'));

			return redirect('/account/password');

		}else{
			return redirect('/account/password')->withErrors([
	            "current_password" => "Şifre Hatalı",
	        ]);
		}
	}




	public function interface($lang = '')
	{
    	if($lang != '') App::setlocale($lang);

    	$image_quality = Auth::User()->image_quality;

        $target = Auth::User()->open_new_tab == 1 ? '_blank' : '_self';

        $watched_movie_number = Rated::where('user_id', Auth::id())->where('rate', '<>', 0)->count();

		return view('accountinterface', compact('image_quality', 'target', 'watched_movie_number'));
	}




	public function change_interface(Request $request, $lang = '')
	{
		if($lang != '') App::setlocale($lang);

		$user = Auth::User();
		$user->lang = $request->lang;
		$user->secondary_lang = $request->secondary_lang;
		$user->hover_title_language = $request->hover_title_language;
		$user->image_quality = $request->image_quality;
		$user->margin_x_setting = $request->margin_x_setting;
		$user->open_new_tab = $request->open_new_tab;
		$user->advanced_filter = $request->advanced_filter;
		$user->show_crew = $request->show_crew;
		$user->pagination = $request->pagination;
		$user->save();

		$request->session()->flash('status', __('general.info_updated'));
		return redirect('/account/interface');
	}




	public function theme($mode = '')
	{
		$user = Auth::User();
		if($mode == 'drk') $user->theme=0;
		else $user->theme=1;
		$user->save();

		return back();
	}




    public function get_cover_pics($lang)
    {
    	$return_val = DB::table('rateds')
    	->where('user_id', Auth::id())
    	->where('rateds.rate', '=', 5)
    	->join('movies', 'movies.id', '=', 'rateds.movie_id')
    	->select(
            'movies.'.$lang.'_title as title',
            'movies.'.$lang.'_cover_path as cover_path',
            'movies.id as movie_id'
        )
    	->orderBy('movies.'.$lang.'_title', 'asc')
        ->get();

  		return $return_val;
    }
}
