<?php

namespace App\Http\Controllers\Api2;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscoverController extends Controller
{
    public function discoverAssign(Request $request)
    {
        if($request->type === 'movie') return $request->retrieve === 'All' ? $this->getTopRatedMovies($request) : $this->getPemosuMovies($request);
    }

    private function getTopRatedMovies($request)
    {
        $start = microtime(true);
    }

    private function getPemosuMovies($request)
    {return explode(',', $request->languages);
        $subq = DB::table('rateds')
        ->where('rateds.user_id', Auth::id())
        ->where('rateds.rate', '>', 0)
        ->leftjoin('recommendations', 'recommendations.movie_id', '=', 'rateds.movie_id')
        ->join('movies', 'movies.id', '=', 'recommendations.this_id')
        ->select(
            'recommendations.this_id as id',
            DB::raw('sum(ABS(rateds.rate-3)*(rateds.rate-3)*recommendations.is_similar) AS point'),
            DB::raw('sum(4*recommendations.is_similar) as p2'),
            DB::raw('COUNT(recommendations.this_id) as count'),
            DB::raw('sum(rateds.rate-1)*25 DIV COUNT(movies.id) as percent')
        )
        ->groupBy('movies.id')
        ->havingRaw('sum(rateds.rate-1)*25 DIV COUNT(movies.id) >= '.$request->min_match_rate.' AND sum(ABS(rateds.rate-3)*(rateds.rate-3)*recommendations.is_similar) > 15');

        if($request->original_languages) { $subq = $subq->whereIn('original_language', $request->original_languages); }
        if($request->f_min != 1917) { $subq = $subq->where('movies.release_date', '>=', Carbon::create($request->f_min,1,1)); }
        if($request->f_max != 2019) { $subq = $subq->where('movies.release_date', '<=', Carbon::create($request->f_max,12,31)); }

        $qqSql = $subq->toSql();
    ////////////////////////////////////////////////////
        $subq_2 = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) { $join->on('movies.id', '=', 'ss.id')->addBinding($subq->getBindings()); }
        )
        ->leftjoin('rateds', function ($join) use ($request) { $join->on('rateds.movie_id', '=', 'movies.id')->where('rateds.user_id', Auth::id()); })
        ->select(
            'ss.id',
            'ss.point',
            'ss.p2',
            'ss.count',
            'ss.percent',
            'rateds.id as rated_id',
            'rateds.rate as rate_code'
        )
        ->groupBy('movies.id');

        if(!$request->f_add_watched) { $subq_2 = $subq_2->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0'); }

        $qqSql_2 = $subq_2->toSql();
    ////////////////////////////////////////////////////
        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql_2. ') AS ss'),
            function($join) use ($subq_2) {
                $join->on('movies.id', '=', 'ss.id')
                ->addBinding($subq_2->getBindings());  
            }
        )
        ->leftjoin('laters', function ($join) { $join->on('laters.movie_id', '=', 'movies.id')->where('laters.user_id', '=', Auth::user()->id); })
        ->leftjoin('bans', function ($join) use ($request) { $join->on('bans.movie_id', '=', 'movies.id')->whereIn('bans.user_id', $request->f_users); })
        ->where('bans.id', '=', null)
        ->select(
            'movies.original_title as original_title',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2',
            'ss.id',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.'.Auth::User()->lang.'_title as title',
            'movies.'.Auth::User()->lang.'_poster_path as poster_path',
            'ss.rated_id',
            'ss.rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->where('movies.vote_count', '>', $request->f_vote);

        if($request->f_sort == 'point') { $return_val = $return_val->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc'); }
        else if($request->f_sort == 'percent') { $return_val = $return_val->orderBy('percent', 'desc')->orderBy('point', 'desc')->orderBy('vote_average', 'desc'); }
        else if($request->f_sort == 'top_rated') { $return_val = $return_val->orderBy('vote_average', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc'); }
        else if($request->f_sort == 'most_popular') { $return_val = $return_val->orderBy('popularity', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc'); }
        else if($request->f_sort == 'budget') { $return_val = $return_val->orderBy('movies.budget', 'desc')->orderBy('movies.revenue', 'desc'); }
        else if($request->f_sort == 'revenue') { $return_val = $return_val->orderBy('movies.revenue', 'desc')->orderBy('movies.budget', 'desc'); }

        if($request->f_genre != []) {
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'ss.id')
            ->whereIn('genre_id', $request->f_genre)
            ->groupBy('movies.id')
            ->havingRaw('COUNT(movies.id)='.count($request->f_genre));
        }

        return $return_val->paginate(Auth::User()->pagination);
    }
}
