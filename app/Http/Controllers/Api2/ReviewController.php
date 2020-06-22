<?php

namespace App\Http\Controllers\Api2;

use App\User;
use App\Model\Review_like;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReviewController extends Controller
{
    public function reviewLikeAssign(Request $request)
    {
        if($request->is_liked == 1) return $this->reviewLike($request->review_id);
        if($request->is_liked == 0) return $this->reviewUnLike($request->review_id);
    }
    
    private function reviewLike($review_id)
    {
        $review_like = Review_like::updateOrCreate(
            ['user_id' => Auth::id(), 'review_id' => $review_id],
            ['is_deleted' => 0]
        );

        $review = DB::table('reviews')
        ->where('reviews.id', $review_id)
        ->first();

        if($review_like->wasRecentlyCreated && $review->user_id > 0){
            if(User::find($review->user_id)->when_user_interaction > 0){
                Notification::updateOrCreate(
                    ['mode' => 0, 'user_id' => $review->user_id, 'multi_id' => $review_id],
                    ['is_seen' => 0]
                );
            }
        }

        return Response::make("", 204);
    }
    
    private function reviewUnLike($review_id)
    {
        $review = Review_like::updateOrCreate(
            ['user_id' => Auth::id(), 'review_id' => $review_id],
            ['is_deleted' => 1]
        );

        Notification::where('multi_id', $review_id)
        ->where('mode', 0)
        ->delete();

        return Response::make("", 204);
    }
}
