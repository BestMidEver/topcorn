<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SettingsController extends Controller
{
    public function settingsAssign(Request $request)
    {
        if($request->type === 'profile') return $this->changeUser($request);
    }

	private function changeUser($request)
	{
		$user = Auth::User();
		if($request->has('name')) {
			$request->validate(['name' => 'required']);
			$user->name = $request->name;
		}
		if($request->has('profile_pic')) $user->profile_pic = $request->profile_pic;
		if($request->has('cover_pic')) $user->cover_pic = $request->cover_pic;
		if($request->has('facebook_link')) $user->facebook_link = $request->facebook_link;
		if($request->has('twitter_link')) $user->twitter_link = $request->twitter_link;
		if($request->has('instagram_link')) $user->instagram_link = $request->instagram_link;
		if($request->has('youtube_link')) $user->youtube_link = $request->youtube_link;
		if($request->has('another_link_url')) $user->another_link_name = 'Website';
		if($request->has('another_link_url')) $user->another_link_url = strlen($user->another_link_url);
		$user->save();
		
        return $user;
	}
}
