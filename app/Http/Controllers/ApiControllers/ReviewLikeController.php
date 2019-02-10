<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Notification;
use App\Model\Review_like;
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
        $review_like = Review_like::updateOrCreate(array('user_id' => Auth::id(), 'review_id' => $request->review_id));

        $review = DB::table('reviews')
        ->where('reviews.id', $request->review_id)
        ->first();
        if(Auth::id() == 7 && $review->user_id != null){
            Notification::updateOrCreate(
                ['mode' => 1, 'user_id' => $review->user_id, 'multi_id' => $request->review_id],
                ['is_seen' => 0]
            );
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
        $will_be_deleted = Review_like::where('review_id', $review_id)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }

        $will_be_deleted = Notification::where('multi_id', $review_id)
        ->where('mode', 1)->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }
        
        return Response(null, Response::HTTP_NO_CONTENT);
    }
}
