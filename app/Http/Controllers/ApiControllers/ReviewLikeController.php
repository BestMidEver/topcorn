<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Notification;
use App\Model\Review_like;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReviewLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $review_like = Review_like::updateOrCreate(
            ['user_id' => Auth::id(), 'review_id' => $request->review_id],
            ['is_deleted' => 0]
        );

        $review = DB::table('reviews')
        ->where('reviews.id', $request->review_id)
        ->first();

        if($review_like->wasRecentlyCreated && $review->user_id>0){
            if(User::find($review->user_id)->when_user_interaction > 0){
                Notification::updateOrCreate(
                    ['mode' => 0, 'user_id' => $review->user_id, 'multi_id' => $request->review_id],
                    ['is_seen' => 0]
                );
            }
        }

        return Response([
            'data' => $review_like,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review_like  $review_like
     * @return \Illuminate\Http\Response
     */
    public function show(Review_like $review_like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review_like  $review_like
     * @return \Illuminate\Http\Response
     */
    public function edit(Review_like $review_like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review_like  $review_like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review_like $review_like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review_like  $review_like
     * @return \Illuminate\Http\Response
     */
    public function destroy($review_id)
    {
        $review = Review_like::updateOrCreate(
            ['user_id' => Auth::id(), 'review_id' => $review_id],
            ['is_deleted' => 1]
        );

        Notification::where('multi_id', $review_id)
        ->where('mode', 0)
        ->delete();

        return Response([
            'data' => $review,
        ], Response::HTTP_NO_CONTENT);
    }
}
