<?php

namespace App\Http\Controllers\Api2;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getSimpleUserData()
    {
        return Auth::user();
    }

    public function getUserData(Request $request)
    {
        return response()->json([
            'user_data' => User::where('id', $request->id)->first(),
            'movies' => $this->getUserMovies($request),
            'series' => $this->getUserSeries($request),
            'movie_reviews' => $this->getUserReviews($request, 1),
            'series_reviews' => $this->getUserReviews($request, 3),
            'people_reviews' => $this->getUserReviews($request, 4),
            'friends' => $this->getFriends($request),
            'interaction_with_user' => $this->getInteractionWithUser($request->id)
        ]);
    }

    public function getUserDetails($id) {
        $user = User::where('id', $id)->first();
        return [
            'user_data' => $user,
            'rated_movies' => $this->rateGrouped($id, 'rateds'),
            'rated_movie_count' => DB::table('rateds')->where('user_id', $id)->where('rate', '>', 0)->count(),
            'rated_series' => $this->rateGrouped($id, 'series_rateds'),
            'rated_series_count' => DB::table('series_rateds')->where('user_id', $id)->where('rate', '>', 0)->count(),
            'follower_count' => DB::table('follows')->where('follows.object_id', $id)->where('follows.is_deleted', 0)->count(),
            'following_count' => DB::table('follows')->where('follows.subject_id', $id)->where('follows.is_deleted', 0)->count(),
            'review_like_count' => DB::table('reviews')->where('reviews.user_id', '=', $id)->leftjoin('review_likes', 'review_likes.review_id', '=', 'reviews.id')->where('review_likes.is_deleted', '=', 0)->whereNotNull('review_likes.id')->count(),
            'review_count' => DB::table('reviews')->where('reviews.user_id', $id)->count()
        ];
    }

    public function getInteractionWithUser($id) {
        $following = DB::table('follows')->where('subject_id', Auth::id())->where('object_id', $id)->where('is_deleted', 0)->first();
        $following_id = $following ? $following->id : null;
        $follows = DB::table('follows')->where('object_id', Auth::id())->where('subject_id', $id)->where('is_deleted', 0)->first();
        $follows_id = $follows ? $follows->id : null;
        $notified_by_id = DB::table('notified_by')->where('subject_id', Auth::id())->where('object_id', $id)->where('mode', 0)->first();
        $notified_by_id = $notified_by_id ? $notified_by_id->id : null;
        return ['following_id' => $following_id, 'follows_id' => $follows_id, 'notified_by_id' => $notified_by_id, 'obj_id' => $id];
    }

    private function rateGrouped($userId, $table) {
        return DB::table($table)
        ->where($table.'.user_id', $userId)
        ->where($table.'.rate', '>', 0)
        ->groupby($table.'.rate')
        ->select(
            $table.'.rate',
            DB::raw('COUNT('.$table.'.id) as count')
        )
        ->get();
    }

    public function getUserInteractionSet(Request $request) {
        if($request->type === 'movie') return $this->getUserMovies($request);
        if($request->type === 'series') return $this->getUserSeries($request);
        if($request->type === 'comment') return $this->getUserReviews($request, $request->mode);
        if($request->type === 'friends') return $this->getFriends($request);
    }

    public function getUserMovies(Request $request)
    {return in_array("Hidden", $request->hide) ? 1 : 2;
        $userId = $request->id;
        $hide = $request->hide ? implode(',', $request->hide) : 'Hidden';
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
            'movies.en_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'movies.vote_count as vote_count',
            'r2.rate as rate_code',
            'l2.id as later_id',
            'b2.id as ban_id',
            DB::raw('GREATEST(COALESCE(rateds.updated_at, 0), COALESCE(laters.updated_at, 0), COALESCE(bans.updated_at, 0)) as updated_at'),
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
        if($request->vote_average > 0 && $request->vote_average != 'All') $return_val = $return_val->where('movies.vote_average', '>', $request->vote_average);
        // Vote Count Filter
        if($request->vote_count > 0 && $request->vote_count != 'All') $return_val = $return_val->where('movies.vote_count', '>', $request->vote_count);
        // User Hide Filter
        if(strpos($hide, 'None') === false) {
            if(strpos($hide, 'Watch Later') !== false) $return_val = $return_val->whereNull('l2.id');
            if(strpos($hide, 'Already Seen') !== false) $return_val = $return_val->where(function ($query) { $query->where('r2.rate', '=', 0)->orWhereNull('r2.rate'); });
            if(strpos($hide, 'Hidden') !== false) $return_val = $return_val->whereNull('b2.id');
        }
        // Sorting
        if($request->sort == 'Most Popular') $return_val = $return_val->orderBy('popularity', 'desc')->orderBy('vote_average', 'desc');
        elseif($request->sort == 'Top Rated') $return_val = $return_val->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc');
        elseif($request->sort == 'Newest') $return_val = $return_val->orderBy('release_date', 'desc')->orderBy('popularity', 'desc');
        elseif($request->sort == 'Alphabetical Order') $return_val = $return_val->orderBy('en_title', 'asc')->orderBy('popularity', 'desc');
        else $return_val = $return_val->orderBy('updated_at', 'desc')->orderBy('popularity', 'desc');
        $return_val = $return_val->paginate(Auth::User()->pagination);
        foreach ($return_val as $row) {
            $row->updated_at = Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans();
        }

        return $return_val;
    }

    public function getUserSeries(Request $request)
    {
        $userId = $request->id;
        $hide = $request->hide ? implode(',', $request->hide) : 'Hidden';
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
            'series.en_poster_path as poster_path',
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
        if($request->vote_average > 0 && $request->vote_average != 'All') $return_val = $return_val->where('series.vote_average', '>', $request->vote_average);
        // Vote Count Filter
        if($request->vote_count > 0 && $request->vote_count != 'All') $return_val = $return_val->where('series.vote_count', '>', $request->vote_count);
        // User Hide Filter
        if(strpos($hide, 'Watch Later') !== false) $return_val = $return_val->whereNull('l2.id');
        if(strpos($hide, 'Already Seen') !== false) $return_val = $return_val->where(function ($query) { $query->where('r2.rate', '=', 0)->orWhereNull('r2.rate'); });
        if(strpos($hide, 'Hidden') !== false) $return_val = $return_val->whereNull('b2.id');
        // Sorting
        if($request->sort == 'Most Popular') $return_val = $return_val->orderBy('popularity', 'desc')->orderBy('vote_average', 'desc');
        elseif($request->sort == 'Top Rated') $return_val = $return_val->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc');
        elseif($request->sort == 'Newest') $return_val = $return_val->orderBy('first_air_date', 'desc')->orderBy('popularity', 'desc');
        elseif($request->sort == 'Alphabetical Order') $return_val = $return_val->orderBy('en_name', 'asc')->orderBy('popularity', 'desc');
        else $return_val = $return_val->orderBy('updated_at', 'desc')->orderBy('popularity', 'desc');
        $return_val = $return_val->paginate(Auth::User()->pagination);
        foreach ($return_val as $row) {
            $row->updated_at = Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans();
        }

        return $return_val;
    }

    public function getUserReviews(Request $request, $mode)
    {
        $review = DB::table('reviews')
        ->where('reviews.user_id',  $request->id)
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
            'reviews.created_at',
            'reviews.review as content',
            'reviews.tmdb_review_id',
            'reviews.lang as url',
            'reviews.id as id',
            'users.name as name',
            'users.id as user_id',
            $mode==4?'people.birthday':'r1.rate as rate',
            'reviews.movie_series_id as movie_series_id',
            ($mode==1?'movies.en_title':($mode==3?'series.en_name':'people.name')).' as obj_name',
            DB::raw('COUNT(review_likes.id) as count'),
            DB::raw('sum(IF(review_likes.user_id = '.Auth::id().', 1, 0)) as is_liked'),
            DB::raw('sum(IF(reviews.user_id = '.Auth::id().', 1, 0)) as is_mine'),
            DB::raw('CASE WHEN reviews.mode=1 THEN "movie" WHEN reviews.mode=3 THEN "series" ELSE "person" END as type')
        )/* 
        ->orderBy('is_mine', 'desc') */;
        // Sorting
        if($request->sort == 'Top Rated') $review = $review->orderBy('count', 'desc')->orderBy('reviews.created_at', 'desc');
        else $review = $review->orderBy('reviews.created_at', 'desc')->orderBy('count', 'desc');

        return $review->paginate(Auth::User()->pagination);
    }

    public function getFriends(Request $request)
    {
        $friends = DB::table('follows')
        ->where('follows.is_deleted', 0)
        ->leftjoin('users as follower', 'follower.id', 'follows.subject_id')
        ->leftjoin('users as following', 'following.id', 'follows.object_id')
        ->orderBy('follows.updated_at', 'desc');
        // Friend type filter
        if($request->mode == 'Friends') $friends = $friends = $friends->where(function ($query) use ($request) { $query->where('follows.subject_id', $request->id)->orWhere('follows.object_id', $request->id); })
        ->select(
            DB::raw('IF(follower.id IS NOT NULL AND following.id IS NOT NULL, IF(follower.id='.$request->id.', following.id, follower.id), NULL) as id'),
            DB::raw('IF(follower.id='.$request->id.', following.name, follower.name) as name'),
            DB::raw('IF(follower.id='.$request->id.', following.facebook_profile_pic, follower.facebook_profile_pic) as facebook_profile_path'),
            DB::raw('IF(follower.id='.$request->id.', following.profile_pic, follower.profile_pic) as profile_path')
        )
        ->havingRaw('COUNT(1)>1')
        ->groupBy(DB::raw('IF(follower.id IS NOT NULL AND following.id IS NOT NULL, IF(follower.id='.$request->id.', following.id, follower.id), NULL)'));
        elseif($request->mode == 'Followers') $friends = $friends->where('follows.object_id', $request->id)
        ->select(
            'follower.id as id',
            'follower.name',
            'follower.facebook_profile_pic as facebook_profile_path',
            'follower.profile_pic as profile_path'
        );
        else $friends = $friends->where('follows.subject_id', $request->id)
        ->select(
            'following.id as id',
            'following.name',
            'following.facebook_profile_pic as facebook_profile_path',
            'following.profile_pic as profile_path'
        );

        return $friends->paginate(Auth::User()->pagination);
    }

    public function getCoverPics()
    {
    	return DB::table('rateds')
    	->where('user_id', Auth::id())
    	->where('rateds.rate', '=', 5)
    	->join('movies', 'movies.id', '=', 'rateds.movie_id')
    	->select(
            'movies.en_title as title',
            'movies.en_cover_path as cover_path',
            'movies.id as movie_id'
        )
    	->orderBy('movies.en_title', 'asc')
        ->get();
    }
}
