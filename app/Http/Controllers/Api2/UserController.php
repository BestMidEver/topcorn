<?php

namespace App\Http\Controllers\Api2;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserData(Request $request)
    {
        return response()->json([
            'user_data' => User::where('id', $request->id == -1 ? Auth::id() : $request->id)->first(),
            'movies' => $this->getUserMovies($request),
            'series' => $this->getUserSeries($request),
            'movie_reviews' => $this->getUserReviews($request, 1),
            'series_reviews' => $this->getUserReviews($request, 3),
            'people_reviews' => $this->getUserReviews($request, 4)
        ]);
    }

    public function getUserMovies(Request $request)
    {
        $userId = $request->id == -1 ? Auth::id() : $request->id;
        $return_val = DB::table('movies')
        ->leftjoin('rateds', function ($join) use ($userId) { $join->on('rateds.movie_id', '=', 'movies.id')->where('rateds.user_id', $userId); })
        ->leftjoin('laters', function ($join) use ($userId) { $join->on('laters.movie_id', '=', 'movies.id')->where('laters.user_id', '=', $userId); })
        ->leftjoin('bans', function ($join) use ($userId) { $join->on('bans.movie_id', '=', 'movies.id')->where('bans.user_id', '=', $userId); })
        ->leftjoin('rateds as r2', function ($join) { $join->on('r2.movie_id', '=', 'movies.id')->where('r2.user_id', Auth::id()); })
        ->leftjoin('laters as l2', function ($join) { $join->on('l2.movie_id', '=', 'movies.id')->where('l2.user_id', '=', Auth::id()); })
        ->leftjoin('bans as b2', function ($join) { $join->on('b2.movie_id', '=', 'movies.id')->where('b2.user_id', '=', Auth::id()); })
        ->select(
            'movies.id as id',
            'movies.en_title as title',
            'movies.original_title',
            'movies.release_date',
            'movies.en_cover_path as cover_path',
            'movies.vote_average as vote_average',
            'movies.vote_count as vote_count',
            'r2.rate as rate_code',
            'l2.id as later_id',
            'b2.id as ban_id',
            DB::raw('GREATEST(COALESCE(rateds.updated_at, 0), COALESCE(laters.updated_at, 0), COALESCE(bans.updated_at, 0)) as updated_at'),
            //DB::raw('IF(rateds.updated_at>laters.updated_at OR laters.updated_at IS NULL, IF(rateds.updated_at>bans.updated_at OR bans.updated_at IS NULL, rateds.updated_at, bans.updated_at), IF(laters.updated_at>bans.updated_at OR bans.updated_at IS NULL, laters.updated_at, bans.updated_at)) as updated_at'),
            'rateds.rate as user_rate_code',
            'laters.id as user_later_id',
            'bans.id as user_ban_id'
        );
        // Profile User Interaction Filter
        if($request->interaction == 'All') $return_val = $return_val->where(function ($query) { $query->where('rateds.rate', '>', 0)->orWhereNotNull('bans.id')->orWhereNotNull('laters.id'); });
        elseif($request->interaction == 'All Seen') $return_val = $return_val->where('rateds.rate', '>', 0);
        elseif(strpos($request->interaction, 'Rate-') !== false) $return_val = $return_val->where('rateds.rate', explode('-', $request->interaction)[1]);
        elseif($request->interaction == 'Hidden') $return_val = $return_val->whereNotNull('bans.id');
        else $return_val = $return_val->whereNotNull('laters.id');
        // Vote Average Filter
        if($request->min_vote_average > 0) $return_val = $return_val->where('movies.vote_average', '>', $request->min_vote_average);
        // Vote Count Filter
        if($request->min_vote_count > 0) $return_val = $return_val->where('movies.vote_count', '>', $request->min_vote_count);
        // User Hide Filter
        if(strpos($request->hide, 'Watch Later') !== false) $return_val = $return_val->whereNull('l2.id');
        if(strpos($request->hide, 'Already Seen') !== false) $return_val = $return_val->where(function ($query) { $query->where('r2.rate', '=', 0)->orWhereNull('r2.rate'); });
        if(strpos($request->hide, 'Hidden') !== false) $return_val = $return_val->whereNull('b2.id');
        // Sorting
        if($request->sort == 'Most Popular') $return_val = $return_val->orderBy('popularity', 'desc');
        elseif($request->sort == 'Top Rated') $return_val = $return_val->orderBy('vote_average', 'desc');
        elseif($request->sort == 'Newest') $return_val = $return_val->orderBy('release_date', 'desc');
        elseif($request->sort == 'Alphabetical Order') $return_val = $return_val->orderBy('en_title', 'asc');
        else $return_val = $return_val->orderBy('updated_at', 'desc');

        /* foreach ($return_val as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        } */

        return $return_val->paginate(Auth::User()->pagination);
    }

    public function getUserSeries(Request $request)
    {
        $userId = $request->id == -1 ? Auth::id() : $request->id;
        $return_val = DB::table('series')
        ->leftjoin('series_rateds', function ($join) use ($userId) { $join->on('series_rateds.series_id', '=', 'series.id')->where('series_rateds.user_id', $userId); })
        ->leftjoin('series_seens', function ($join) use ($userId) { $join->on('series_seens.series_id', '=', 'series.id')->where('series_seens.user_id', $userId); })
        ->leftjoin('series_laters', function ($join) use ($userId) { $join->on('series_laters.series_id', '=', 'series.id')->where('series_laters.user_id', '=', $userId); })
        ->leftjoin('series_bans', function ($join) use ($userId) { $join->on('series_bans.series_id', '=', 'series.id')->where('series_bans.user_id', '=', $userId); })
        ->leftjoin('series_rateds as r2', function ($join) { $join->on('r2.series_id', '=', 'series.id')->where('r2.user_id', Auth::id()); })
        ->leftjoin('series_laters as l2', function ($join) { $join->on('l2.series_id', '=', 'series.id')->where('l2.user_id', '=', Auth::id()); })
        ->leftjoin('series_bans as b2', function ($join) { $join->on('b2.series_id', '=', 'series.id')->where('b2.user_id', '=', Auth::id()); })
        ->select(
            'series.id as id',
            'series.en_name as name',
            'series.original_name',
            'series.first_air_date',
            'series.en_backdrop_path as backdrop_path',
            'series.vote_average as vote_average',
            'series.vote_count as vote_count',
            'r2.rate as rate_code',
            'l2.id as later_id',
            'b2.id as ban_id',
            DB::raw('GREATEST(COALESCE(series_rateds.updated_at, 0), COALESCE(series_seens.updated_at, 0), COALESCE(series_laters.updated_at, 0), COALESCE(series_bans.updated_at, 0)) as updated_at'),
            'series_rateds.rate as user_rate_code',
            'series_laters.id as user_later_id',
            'series_bans.id as user_ban_id'
        );
        // Profile User Interaction Filter
        if($request->interaction == 'All') $return_val = $return_val->where(function ($query) { $query->where('series_rateds.rate', '>', 0)->orWhereNotNull('series_bans.id')->orWhereNotNull('series_laters.id'); });
        elseif($request->interaction == 'All Seen') $return_val = $return_val->where('series_rateds.rate', '>', 0);
        elseif(strpos($request->interaction, 'Rate-') !== false) $return_val = $return_val->where('series_rateds.rate', explode('-', $request->interaction)[1]);
        elseif($request->interaction == 'Hidden') $return_val = $return_val->whereNotNull('series_bans.id');
        else $return_val = $return_val->whereNotNull('series_laters.id');
        // Vote Average Filter
        if($request->min_vote_average > 0) $return_val = $return_val->where('series.vote_average', '>', $request->min_vote_average);
        // Vote Count Filter
        if($request->min_vote_count > 0) $return_val = $return_val->where('series.vote_count', '>', $request->min_vote_count);
        // User Hide Filter
        if(strpos($request->hide, 'Watch Later') !== false) $return_val = $return_val->whereNull('l2.id');
        if(strpos($request->hide, 'Already Seen') !== false) $return_val = $return_val->where(function ($query) { $query->where('r2.rate', '=', 0)->orWhereNull('r2.rate'); });
        if(strpos($request->hide, 'Hidden') !== false) $return_val = $return_val->whereNull('b2.id');
        // Sorting
        if($request->sort == 'Most Popular') $return_val = $return_val->orderBy('popularity', 'desc');
        elseif($request->sort == 'Top Rated') $return_val = $return_val->orderBy('vote_average', 'desc');
        elseif($request->sort == 'Newest') $return_val = $return_val->orderBy('first_air_date', 'desc');
        elseif($request->sort == 'Alphabetical Order') $return_val = $return_val->orderBy('en_title', 'asc');
        else $return_val = $return_val->orderBy('updated_at', 'desc');

        /* foreach ($return_val as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        } */

        return $return_val->paginate(Auth::User()->pagination);
    }

    public function getUserReviews(Request $request, $mode)
    {
        $userId = $request->id == -1 ? Auth::id() : $request->id;
        $review = DB::table('reviews')
        ->where('reviews.user_id', $userId)
        ->where('reviews.mode', $mode)
        ->leftjoin('users', 'users.id', '=', 'reviews.user_id')
        ->leftjoin('review_likes', function ($join) {
            $join->on('review_likes.review_id', '=', 'reviews.id')
            ->where('review_likes.is_deleted', '=', 0);
        })
        ->groupBy('reviews.id');
        if($mode==1){
            $review=$review
            ->leftjoin('movies', 'movies.id', 'reviews.movie_series_id')
            ->leftjoin('rateds as r1', function ($join) {
                $join->on('r1.movie_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }elseif($mode==3){
            $review=$review
            ->leftjoin('series', 'series.id', 'reviews.movie_series_id')
            ->leftjoin('series_rateds as r1', function ($join) {
                $join->on('r1.series_id', '=', 'reviews.movie_series_id');
                $join->on('r1.user_id', '=', 'reviews.user_id');
            });
        }elseif($mode==4){
            $review=$review
            ->leftjoin('people', 'people.id', 'reviews.movie_series_id');
        }
        $review = $review
        ->select(
            'reviews.tmdb_author_name as author',
            'reviews.review as content',
            'reviews.tmdb_review_id',
            'reviews.lang as url',
            'reviews.id as id',
            'users.name as name',
            'users.id as user_id',
            $mode==4?'people.birthday':'r1.rate as rate',
            'reviews.movie_series_id as movie_series_id',
            $mode==1?'movies.en_title as title':($mode==3?'series.en_name as name':'people.name as name'),
            DB::raw('COUNT(review_likes.id) as count'),
            DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
            DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine')
        )
        ->orderBy('is_mine', 'desc')
        ->orderBy('count', 'desc');

        return $review->paginate(Auth::User()->pagination);
    }
}
