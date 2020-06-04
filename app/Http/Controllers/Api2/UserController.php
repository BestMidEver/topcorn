<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserData(Request $request)
    {
        return response()->json([
            'movies' => $this->getUserMovies($request)
        ]);
    }

    public function getUserMovies(Request $request)
    {
        $userId = $request->id == -1 ? Auth::id() : $request->id;
        $return_val = DB::table('movies')
        ->leftjoin('rateds', function ($join) use ($userId) { $join->on('rateds.movie_id', '=', 'movies.id')->where('rateds.user_id', $userId); })
        ->leftjoin('laters', function ($join) use ($userId) { $join->on('laters.movie_id', '=', 'movies.id')->where('laters.user_id', '=', $userId); })
        ->leftjoin('bans', function ($join) use ($userId) { $join->on('bans.movie_id', '=', 'movies.id')->where('bans.user_id', '=', $userId); })
        ->where(function ($query) { $query->where('rateds.rate', '>', 0)->orWhereNotNull('bans.id')->orWhereNotNull('laters.id'); })
        ->leftjoin('rateds as r2', function ($join) { $join->on('r2.movie_id', '=', 'movies.id')->where('r2.user_id', Auth::id()); })
        ->leftjoin('laters as l2', function ($join) { $join->on('l2.movie_id', '=', 'movies.id')->where('l2.user_id', '=', Auth::id()); })
        ->leftjoin('bans as b2', function ($join) { $join->on('b2.movie_id', '=', 'movies.id')->where('b2.user_id', '=', Auth::id()); })
        ->select(
            'movies.id as id',
            'movies.en_title as title',
            'movies.original_title as original_title',
            'movies.release_date as release_date',
            //'movies.en_poster_path as poster_path',
            'movies.en_cover_path as cover_path',
            'movies.vote_average as vote_average',
            'movies.vote_count as vote_count',
            'r2.rate as rate_code',
            'l2.id as later_id',
            'b2.id as ban_id',
            DB::raw('IF(rateds.updated_at>laters.updated_at OR laters.updated_at IS NULL, IF(rateds.updated_at>bans.updated_at OR bans.updated_at IS NULL, rateds.updated_at, bans.updated_at), IF(laters.updated_at>bans.updated_at OR bans.updated_at IS NULL, laters.updated_at, bans.updated_at)) as updated_at'),
            'rateds.rate as user_rate_code',
            'laters.id as user_later_id',
            'bans.id as user_ban_id'
        );
        // Profile User Interaction Filter
        if($request->interaction == 'Watch Later') $return_val = $return_val->whereNotNull('laters.id');
        elseif(strpos($request->interaction, 'Rate-') !== false) $return_val = $return_val->where('rateds.rate', explode('-', $request->interaction)[1]);
        elseif($request->interaction == 'Hidden') $return_val = $return_val->whereNotNull('bans.id');
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
}
