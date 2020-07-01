<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function settingsAssign(Request $request)
    {
        if($request->type === 'profile') return $this->changeUser($request);
        if($request->type === 'password') return $this->changePassword($request);
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
		if($request->has('another_link_url')) $user->another_link_url = $request->another_link_url ? (strpos($str, "https://") === 0 ? $request->another_link_url : 'https://'.$request->another_link_url) : null;
		if($request->has('pagination')) $user->pagination = $request->pagination;
		if($request->has('when_user_interaction')) $user->when_user_interaction = $request->when_user_interaction;
		if($request->has('when_automatic_notification')) $user->when_automatic_notification = $request->when_automatic_notification;
		if($request->has('when_system_change')) $user->when_system_change = $request->when_system_change;
		$user->save();
		
        return $user;
	}

	private function changePassword($request)
	{
		$validator = Validator::make($request->all(), [
			'current_password' => 'required|min:6',
			'new_password' => 'required|confirmed|min:6',
		]);
		if ($validator->fails()) {
			return response()->json(array(
				'success' => false,
				'errors' => $validator->getMessageBag()->toArray()
			), 400); // 400 being the HTTP code for an invalid request.
		}
		if(Hash::check($request->current_password, Auth::User()->password)){
			$user = Auth::User();
			$user->password = Hash::make($request->new_password);
			$user->save();
			return Response::make("", 204);
		}
		return response()->json(['errors' => ['current_password' => ['Current password is not correct.']]], 401);
	}
}
