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

		return view('account', compact('image_quality', 'target', 'watched_movie_number'));
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
		if($user->level == 503){
			$user->level = 504;
		}
		$user->save();

		$request->session()->flash('status', 'Bilgileriniz başarıyla güncellendi.');

		return redirect('/account');
	}

	


	public function password($lang = '')
	{
    	if($lang != '') App::setlocale($lang);

    	$is_from_facebook=0;
		if(Auth::User()->facebook_id){
			if(Hash::check(Auth::User()->facebook_id, Auth::User()->password)){
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

			$request->session()->flash('status', 'Şifreniz başarıyla güncellendi.');

			return redirect('/account/password');

		}else if(Hash::check($request->current_password, Auth::User()->password)){

			$request->validate([
				'current_password' => 'required|min:6',
	            'new_password' => 'required|confirmed|min:6',
			]);
			$user = Auth::User();
			$user->password = Hash::make($request->new_password);
			$user->save();

			$request->session()->flash('status', 'Şifreniz başarıyla güncellendi.');

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
		$user->save();

		$request->session()->flash('status', 'Bilgileriniz başarıyla güncellendi.');
		return redirect('/account/interface');
	}




	public function change_insta_language($lang)
	{
		if(Auth::check() == 1){
	    	$user = Auth::User();
			$user->lang = $lang;
			$user->save();
		}else{
			Session::put('insta_language_change_used', $lang);
		}
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
