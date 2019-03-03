<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Model\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
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

        if($request->season_number != -1){
            if($request->episode_number != -1){
                Review::updateOrCreate(
                    array('user_id' => Auth::id(), 'movie_series_id' => $request->movie_series_id, 'season_number' => $request->season_number, 'episode_number' => $request->episode_number),
                    array('review' => strip_tags($request->review), 'mode' => $request->mode, 'lang' => Auth::User()->lang)
                );
            }else{
                Review::updateOrCreate(
                    array('user_id' => Auth::id(), 'movie_series_id' => $request->movie_series_id, 'season_number' => $request->season_number, 'episode_number' => null),
                    array('review' => strip_tags($request->review), 'mode' => $request->mode, 'lang' => Auth::User()->lang)
                );
            }
        }else{
            Review::updateOrCreate(
                array('user_id' => Auth::id(), 'movie_series_id' => $request->movie_series_id, 'season_number' => null, 'episode_number' => null),
                array('review' => strip_tags($request->review), 'mode' => $request->mode, 'lang' => Auth::User()->lang)
            );
        }

        if($request->mode==1) $mode=[0,1];
        else $mode=[2,3];

        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $request->movie_series_id)
        ->whereIn('reviews.mode', $mode)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id')
            ->where('review_likes.is_deleted', '=', 0);
        })
        ->groupBy('reviews.id')
        ->select(
            'reviews.tmdb_author_name as author',
            'reviews.review as content',
            'reviews.tmdb_review_id as id',
            'reviews.lang as url',
            'reviews.id as review_id',
            'users.name as name',
            'users.id as user_id',
            'r1.rate as rate',
            DB::raw('COUNT(review_likes.id) as count'),
            DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
            DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
        )
        ->orderBy('is_mine', 'desc')
        ->orderBy('count', 'desc');

        if($mode[0]==0){
            $review=$review
            ->leftjoin('rateds as r1', function ($join) {
                $join->on('r1.movie_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }else{
            $review=$review
            ->leftjoin('series_rateds as r1', function ($join) {
                $join->on('r1.series_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }

        if($request->season_number != -1){
            if($request->episode_number != -1){
                $review=$review
                ->where('reviews.season_number', '=', $request->season_number)
                ->where('reviews.episode_number', '=', $request->episode_number);
            }else{
                $review=$review
                ->where('reviews.season_number', '=', $request->season_number)
                ->whereNull('reviews.episode_number');
            }
        }/*else{
            $review=$review
            ->whereNull('reviews.season_number')
            ->whereNull('reviews.episode_number');
        }*/

        return Response([
            'data' => $review->paginate(25),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($movie_series_id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show_reviews(Request $request)
    {
        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $request->movie_series_id)
        ->whereIn('reviews.mode', $request->mode)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id')
            ->where('review_likes.is_deleted', '=', 0);
        })
        ->groupBy('reviews.id');

        if($request->mode[0]==0){
            $review=$review
            ->leftjoin('rateds as r1', function ($join) {
                $join->on('r1.movie_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }else{
            $review=$review
            ->leftjoin('series_rateds as r1', function ($join) {
                $join->on('r1.series_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }

        if($request->season_number != -1){
            if($request->episode_number != -1){
                $review=$review
                ->where('reviews.season_number', '=', $request->season_number)
                ->where('reviews.episode_number', '=', $request->episode_number);
            }else{
                $review=$review
                ->where('reviews.season_number', '=', $request->season_number)
                ->whereNull('reviews.episode_number');
            }
        }else{
            $review=$review
            ->whereNull('reviews.season_number')
            ->whereNull('reviews.episode_number');
        }

        if(Auth::check()){
            $review = $review
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                'r1.rate as rate',
                'reviews.movie_series_id as movie_series_id',
                DB::raw('COUNT(review_likes.id) as count'),
                DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
                DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
            )
            ->orderBy('is_mine', 'desc')
            ->orderBy('count', 'desc');
        }else{
            $review = $review
            ->select(
                'reviews.tmdb_author_name as author',
                'reviews.review as content',
                'reviews.tmdb_review_id as id',
                'reviews.lang as url',
                'reviews.id as review_id',
                'users.name as name',
                'users.id as user_id',
                'r1.rate as rate',
                DB::raw('COUNT(review_likes.id) as count')
            )
            ->orderBy('count', 'desc');
        }

        return $review->paginate(25);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($movie_series_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy_review(Request $request)
    {
        $will_be_deleted = Review::where('id', $request->review_id)
        ->where('user_id', Auth::id())->first();
        
        if($will_be_deleted){
            $will_be_deleted->delete();
        }

        $review = DB::table('reviews')
        ->where('reviews.movie_series_id', $request->movie_series_id)
        ->whereIn('reviews.mode', $request->mode)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id')
            ->where('review_likes.is_deleted', '=', 0);
        })
        ->groupBy('reviews.id')
        ->select(
            'reviews.tmdb_author_name as author',
            'reviews.review as content',
            'reviews.tmdb_review_id as id',
            'reviews.lang as url',
            'reviews.id as review_id',
            'users.name as name',
            'users.id as user_id',
            'r1.rate as rate',
            DB::raw('COUNT(review_likes.id) as count'),
            DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
            DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
        )
        ->orderBy('is_mine', 'desc')
        ->orderBy('count', 'desc');
        
        if($request->mode[0]==0){
            $review=$review
            ->leftjoin('rateds as r1', function ($join) {
                $join->on('r1.movie_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }else{
            $review=$review
            ->leftjoin('series_rateds as r1', function ($join) {
                $join->on('r1.series_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }

        if($request->season_number != -1){
            if($request->episode_number != -1){
                $review=$review
                ->where('reviews.season_number', '=', $request->season_number)
                ->where('reviews.episode_number', '=', $request->episode_number);
            }else{
                $review=$review
                ->where('reviews.season_number', '=', $request->season_number)
                ->whereNull('reviews.episode_number');
            }
        }else{
            $review=$review
            ->whereNull('reviews.season_number')
            ->whereNull('reviews.episode_number');
        }
        
        return Response([
            'data' => $review->paginate(25),
        ], Response::HTTP_CREATED);
    }
}
