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
    {
        $subq = DB::table('rateds')
        ->where('rateds.user_id', Auth::id())
        ->where('rateds.rate', '>', $request->retrieve === 'My Votes' ? 0 : 4)
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
        // Vote Average Filter
        if($request->min_vote_average > 0 && $request->min_vote_average != 'All') $subq = $subq->where('movies.vote_average', '>', $request->min_vote_average);
        // Vote Count Filter
        if($request->min_vote_count > 0 && $request->min_vote_count != 'All') $subq = $subq->where('movies.vote_count', '>', $request->min_vote_count);

        if($request->original_languages) { $subq = $subq->whereIn('original_language', $request->original_languages); }
        if($request->min_year) { $subq = $subq->where('movies.release_date', '>=', Carbon::create($request->min_year,1,1)); }
        if($request->max_year) { $subq = $subq->where('movies.release_date', '<=', Carbon::create($request->max_year,12,31)); }

        $qqSql = $subq->toSql();
    ////////////////////////////////////////////////////
        $subq_2 = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) { $join->on('movies.id', '=', 'ss.id')->addBinding($subq->getBindings()); }
        )
        ->leftjoin('rateds', function ($join) { $join->on('rateds.movie_id', '=', 'movies.id')->where('rateds.user_id', Auth::id()); })
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

        //if(!$request->f_add_watched) { $subq_2 = $subq_2->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0'); }

        $qqSql_2 = $subq_2->toSql();
    ////////////////////////////////////////////////////
        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql_2. ') AS ss'),
            function($join) use ($subq_2) { $join->on('movies.id', '=', 'ss.id')->addBinding($subq_2->getBindings()); }
        )
        ->leftjoin('laters', function ($join) { $join->on('laters.movie_id', '=', 'movies.id')->where('laters.user_id', '=', Auth::id()); })
        ->leftjoin('bans', function ($join) use ($request) { $join->on('bans.movie_id', '=', 'movies.id')->where('bans.user_id', Auth::id()); })
        //->where('bans.id', '=', null)
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
            'movies.en_title as title',
            'movies.en_poster_path as poster_path',
            'ss.rated_id',
            'ss.rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->where('movies.vote_count', '>', $request->min_vote_count);

        // Sorting
        if($request->sorting === 'Match Score') { $return_val = $return_val->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc'); }
        elseif($request->sort == 'Newest') $return_val = $return_val->orderBy('release_date', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc');
        else if($request->sorting == 'Top Rated') { $return_val = $return_val->orderBy('vote_average', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sorting == 'Most Popular') { $return_val = $return_val->orderBy('popularity', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc'); }
        else if($request->sorting == 'Highest Budget') { $return_val = $return_val->orderBy('movies.budget', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sorting == 'Highest Revenue') { $return_val = $return_val->orderBy('movies.revenue', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }

        if($request->genre_combination) {
            $return_val = $return_val->join('genres', 'genres.movie_id', '=', 'ss.id')
            ->whereIn('genre_id', $request->genre_combination)
            ->groupBy('movies.id')
            ->havingRaw('COUNT(movies.id)='.count($request->genre_combination));
        }

        return $return_val->paginate(Auth::User()->pagination);
    }
}
