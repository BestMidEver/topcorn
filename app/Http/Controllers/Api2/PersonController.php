<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    public function getPersonData(Request $request, $id)
    {
        return response()->json([
            'reviews' => $this->reviewData($request, $id),
        ]);
    }
    
    public function reviewData(Request $request, $id)
    {
        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $id)
        ->where('reviews.mode', 4)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id')
            ->where('review_likes.is_deleted', '=', 0);
        })
        ->groupBy('reviews.id');

        $review = $review
        ->select(
            'reviews.review as content',
            'reviews.lang',
            'reviews.id as id',
            'users.name as name',
            'users.id as user_id',
            'reviews.movie_series_id as movie_series_id',
            DB::raw('COUNT(review_likes.id) as count'),
            DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
            DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
        )
        ->orderBy('is_mine', 'desc')
        ->orderBy('count', 'desc');

        return $review->paginate(Auth::User()->pagination);
    }
}
