<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationEmailJob;
use App\Model\Follow;
use App\Model\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $old_follow = Follow::where('subject_id', '=', Auth::id())
        ->where('object_id', '=', 1)
        ->first();
        $follow = Follow::updateOrCreate(
            ['subject_id' => Auth::id(), 'object_id' => 1],
            ['is_deleted' => 0]
        );
        if(!$old_follow && $follow){
            $notification = Notification::updateOrCreate(
                ['mode' => 8, 'user_id' => 1, 'multi_id' => Auth::id()],
                ['is_seen' => 0]
            );

            if(User::find(1)->when_recommendation > 1) SendNotificationEmailJob::dispatch($notification->id)->onQueue("high");
        }
        return Response([
            'data' => $follow,
        ], Response::HTTP_CREATED);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $old_follow = Follow::where('subject_id', '=', Auth::id())
        ->where('object_id', '=', $request->object_id)
        ->first();
        $follow = Follow::updateOrCreate(
            ['subject_id' => Auth::id(), 'object_id' => $request->object_id],
            ['is_deleted' => 0]
        );
        if(!$old_follow && $follow){
            $notification = Notification::updateOrCreate(
                ['mode' => 8, 'user_id' => $request->object_id, 'multi_id' => Auth::id()],
                ['is_seen' => 0]
            );

            if(User::find($request->object_id)->when_recommendation > 1) SendNotificationEmailJob::dispatch($notification->id)->onQueue("high");
        }
        return Response([
            'data' => $follow,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy($object_id)
    {
        $follow = Follow::updateOrCreate(
            ['subject_id' => Auth::id(), 'object_id' => $object_id],
            ['is_deleted' => 1]
        );

        Notification::where('multi_id', Auth::id())
        ->where('user_id', $object_id)
        ->where('mode', 8)
        ->delete();

        return Response([
            'data' => $follow,
        ], Response::HTTP_NO_CONTENT);
    }




    public function show_followers($object_id, $mode)
    {
        $follow = Follow::updateOrCreate(
            ['subject_id' => Auth::id(), 'object_id' => $object_id],
            ['is_deleted' => 1]
        );
        return Response([
            'data' => $follow,
        ], Response::HTTP_NO_CONTENT);
    }




    public function show_followings($object_id, $mode)
    {
        $follow = Follow::updateOrCreate(
            ['subject_id' => Auth::id(), 'object_id' => $object_id],
            ['is_deleted' => 1]
        );
        return Response([
            'data' => $follow,
        ], Response::HTTP_NO_CONTENT);
    }
}
