<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function settingsAssign(Request $request)
    {
        if($request->type === 'profile') return $this->changeUser($request);
    }

	private function changeUser($request)
	{
		$request->validate([
			'name' => 'required|min:6',
			]);
		return $request;
			
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
}
