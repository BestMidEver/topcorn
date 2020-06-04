<?php

namespace App\Http\Controllers\Api2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $return_val = DB::table('movies')
        ->leftjoin('rateds as r2', function ($join) {
            $join->on('r2.movie_id', '=', 'movies.id')
            ->where('r2.user_id', Auth::id());
        })
        ->leftjoin('laters as l2', function ($join) {
            $join->on('l2.movie_id', '=', 'movies.id')
            ->where('l2.user_id', '=', Auth::id());
        })
        ->leftjoin('bans as b2', function ($join) {
            $join->on('b2.movie_id', '=', 'movies.id')
            ->where('b2.user_id', '=', Auth::id());    
        })
        ->select(
            'movies.id as id',
            'movies.en_title as title',
            'movies.original_title as original_title',
            'movies.release_date as release_date',
            'movies.en_poster_path as poster_path',
            'movies.vote_average as vote_average',
            'movies.vote_count as vote_count',
            'r2.rate as rate_code',
            'l2.id as later_id',
            'b2.id as ban_id',
            'rateds.updated_at as updated_at'
        )
        ->orderBy('rateds.updated_at', 'desc');

        /* if($rate=='all'){
            $return_val = $return_val->where('rateds.rate', '<>', 0)
            ->paginate($pagin);
        }else{
            $return_val = $return_val->where('rateds.rate', $rate)
            ->paginate($pagin);
        } */

        /* foreach ($return_val as $row) {
            $row->updated_at = timeAgo(explode(' ', Carbon::createFromTimeStamp(strtotime($row->updated_at))->diffForHumans()));
        } */

        return $return_val->paginate(Auth::User()->pagination);
    }
}
