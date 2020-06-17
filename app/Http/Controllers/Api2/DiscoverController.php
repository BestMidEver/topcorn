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
        if($request->type === 'series') return $request->retrieve === 'All' ? $this->getTopRatedSeries($request) : $this->getPemosuSeries($request);
    }

    private function getTopRatedMovies($request)
    {
        $subq = DB::table('rateds')
        ->where('rateds.user_id', Auth::id())
        ->where('rateds.rate', '>', 0)
        ->leftjoin('recommendations', 'recommendations.movie_id', 'rateds.movie_id')
        ->join('movies', 'movies.id', 'recommendations.this_id')
        ->select(
            'movies.id',
            DB::raw('sum(ABS(rateds.rate-3)*(rateds.rate-3)*recommendations.is_similar) AS point'),
            DB::raw('sum(4*recommendations.is_similar) as p2'),
            DB::raw('COUNT(recommendations.this_id) as count'),
            DB::raw('sum(rateds.rate-1)*25 DIV COUNT(movies.id) as percent')
        )
        ->groupBy('movies.id');
        $qqSql = $subq->toSql();
    /////////////////////////////////////////////////////////
        $subq_2 = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') as ss'),
            function($join) use ($subq) { $join->on('movies.id', 'ss.id')->addBinding($subq->getBindings()); }
        )
        ->rightjoin('movies as m2', 'm2.id', 'movies.id')
        ->select(
            'm2.id',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2'
        )
        /* ->where('m2.vote_count', '>', $request->f_vote)
        ->where('m2.vote_average', '>', config('constants.suck_page.min_vote_average')) */;

        // Vote Average Filter
        if($request->min_vote_average > 0 && $request->min_vote_average != 'All') $subq_2 = $subq_2->where('movies.vote_average', '>', $request->min_vote_average);
        // Vote Count Filter
        if($request->min_vote_count > 0 && $request->min_vote_count != 'All') $subq_2 = $subq_2->where('movies.vote_count', '>', $request->min_vote_count);
        
        /* if($request->f_genre != []) {
            $subq_2 = $subq_2->join('genres', 'genres.movie_id', 'm2.id')
            ->whereIn('genre_id', $request->f_genre)
            ->groupBy('m2.id')
            ->havingRaw('COUNT(m2.id)='.count($request->f_genre));
        }; */

        /* if($request->f_lang != []) { $subq_2 = $subq_2->whereIn('m2.original_language', $request->f_lang); }
        if($request->f_min != 1917) { $subq_2 = $subq_2->where('m2.release_date', '>=', Carbon::create($request->f_min,1,1)); }
        if($request->f_max != 2020) { $subq_2 = $subq_2->where('m2.release_date', '<=', Carbon::create($request->f_max,12,31)); }
         */$qqSql_2 = $subq_2->toSql();

    /////////////////////////////////////////////////////////

        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql_2. ') AS ss'),
            function($join) use ($subq_2) { $join->on('movies.id', 'ss.id')->addBinding($subq_2->getBindings()); }
        )
        ->leftjoin('rateds', function ($join) use ($request) { $join->on('rateds.movie_id', 'movies.id') ->where('rateds.user_id', Auth::id()); })
        ->leftjoin('laters', function ($join) { $join->on('laters.movie_id', 'movies.id') ->where('laters.user_id', Auth::id()); })
        ->leftjoin('bans', function ($join) use ($request) { $join->on('bans.movie_id', 'movies.id') ->where('bans.user_id', Auth::id()); })
        ->select(
            'movies.id',
            'movies.original_title as original_title',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.en_title as title',
            'movies.en_poster_path as poster_path',
            'movies.en_cover_path as cover_path',
            'rateds.id as rated_id',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->groupBy('movies.id');
        // User Hide Filter
        if($request->hide && !in_array('None', $request->hide)) {
            if(in_array('Watch Later', $request->hide)) $return_val = $return_val->whereNull('laters.id');
            if(in_array('Already Seen', $request->hide)) $return_val = $return_val->where(function ($query) { $query->where('rateds.rate', 0)->orWhereNull('rateds.rate'); });
            if(in_array('Hidden', $request->hide)) $return_val = $return_val->whereNull('bans.id');
        }
        // Sorting
        if($request->sort === 'Match Score') { $return_val = $return_val->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc'); }
        elseif($request->sort == 'Newest') { $return_val = $return_val->orderBy('release_date', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Top Rated') { $return_val = $return_val->orderBy('vote_average', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Most Popular') { $return_val = $return_val->orderBy('popularity', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc'); }
        else if($request->sort == 'Highest Budget') { $return_val = $return_val->orderBy('movies.budget', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Highest Revenue') { $return_val = $return_val->orderBy('movies.revenue', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        /* if(!$request->f_add_watched){ $return_val = $return_val->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0 AND sum(IF(bans.id IS NULL, 0, 1)) = 0'); }

        if($request->f_sort == 'most_popular') { $return_val = $return_val->orderBy('movies.popularity', 'desc'); }
        else if($request->f_sort == 'top_rated') { $return_val = $return_val->orderBy('movies.vote_average', 'desc')->orderBy('movies.vote_count', 'desc'); }
        else if($request->f_sort == 'budget') { $return_val = $return_val->orderBy('movies.budget', 'desc')->orderBy('movies.revenue', 'desc'); }
        else if($request->f_sort == 'revenue') { $return_val = $return_val->orderBy('movies.revenue', 'desc')->orderBy('movies.budget', 'desc'); }
 */
        return $return_val->paginate(Auth::User()->pagination);
    }

    private function getPemosuMovies($request)
    {
        $subq = DB::table('rateds')
        ->where('rateds.user_id', Auth::id())
        ->where('rateds.rate', '>', $request->retrieve === 'My Votes' ? 0 : 4)
        ->leftjoin('recommendations', 'recommendations.movie_id', 'rateds.movie_id')
        ->join('movies', 'movies.id', 'recommendations.this_id')
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
        // Original Languages Filter
        if($request->original_languages) { $subq = $subq->whereIn('original_language', $request->original_languages); }
        // Year Filters
        if($request->min_year) { $subq = $subq->where('movies.release_date', '>=', Carbon::create($request->min_year,1,1)); }
        if($request->max_year) { $subq = $subq->where('movies.release_date', '<=', Carbon::create($request->max_year,12,31)); }
        $qqSql = $subq->toSql();
        $return_val = DB::table('movies')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) { $join->on('movies.id', 'ss.id')->addBinding($subq->getBindings()); }
        )
        ->leftjoin('rateds', function ($join) { $join->on('rateds.movie_id', 'movies.id')->where('rateds.user_id', Auth::id()); })
        ->leftjoin('laters', function ($join) { $join->on('laters.movie_id', 'movies.id')->where('laters.user_id', Auth::id()); })
        ->leftjoin('bans', function ($join) use ($request) { $join->on('bans.movie_id', 'movies.id')->where('bans.user_id', Auth::id()); })
        ->select(
            'movies.original_title',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2',
            'ss.id',
            'movies.vote_average',
            'movies.vote_count',
            'movies.release_date',
            'movies.en_title as title',
            'movies.en_cover_path as cover_path',
            'movies.en_poster_path as poster_path',
            'rateds.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        );
        // User Hide Filter
        if($request->hide && !in_array('None', $request->hide)) {
            if(in_array('Watch Later', $request->hide)) $return_val = $return_val->whereNull('laters.id');
            if(in_array('Already Seen', $request->hide)) $return_val = $return_val->where(function ($query) { $query->where('rateds.rate', 0)->orWhereNull('rateds.rate'); });
            if(in_array('Hidden', $request->hide)) $return_val = $return_val->whereNull('bans.id');
        }
        // Sorting
        if($request->sort === 'Match Score') { $return_val = $return_val->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc'); }
        elseif($request->sort == 'Newest') { $return_val = $return_val->orderBy('release_date', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Top Rated') { $return_val = $return_val->orderBy('vote_average', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Most Popular') { $return_val = $return_val->orderBy('popularity', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc'); }
        else if($request->sort == 'Highest Budget') { $return_val = $return_val->orderBy('movies.budget', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Highest Revenue') { $return_val = $return_val->orderBy('movies.revenue', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        if($request->genre_combination) {
            $return_val = $return_val->join('genres', 'genres.movie_id', 'movies.id')
            ->whereIn('genre_id', $request->genre_combination)
            ->groupBy('movies.id')
            ->havingRaw('COUNT(movies.id)='.count($request->genre_combination));
        }

        return $return_val->paginate(Auth::User()->pagination);
    }

    private function getTopRatedSeries($request)
    {
    }

    private function getPemosuSeries($request)
    {
        $subq = DB::table('series_rateds')
        ->where('series_rateds.user_id', Auth::id())
        ->where('series_rateds.rate', '>', $request->retrieve === 'My Votes' ? 0 : 4)
        ->leftjoin('series_recommendations', 'series_recommendations.series_id', 'series_rateds.series_id')
        ->join('series', 'series.id', 'series_recommendations.this_id')
        ->select(
            'series_recommendations.this_id as id',
            DB::raw('sum(ABS(series_rateds.rate-3)*(series_rateds.rate-3)*series_recommendations.rank) AS point'),
            DB::raw('sum(4*series_recommendations.rank) as p2'),
            DB::raw('COUNT(series_recommendations.this_id) as count'),
            DB::raw('sum(series_rateds.rate-1)*25 DIV COUNT(series.id) as percent')
        )
        ->groupBy('series.id')
        ->havingRaw('sum(series_rateds.rate-1)*25 DIV COUNT(series.id) >= '.$request->min_match_rate.' AND sum(ABS(series_rateds.rate-3)*(series_rateds.rate-3)*series_recommendations.rank) > 15');
        // Vote Average Filter
        if($request->min_vote_average > 0 && $request->min_vote_average != 'All') $subq = $subq->where('series.vote_average', '>', $request->min_vote_average);
        // Vote Count Filter
        if($request->min_vote_count > 0 && $request->min_vote_count != 'All') $subq = $subq->where('series.vote_count', '>', $request->min_vote_count);
        // Original Languages Filter
        if($request->original_languages) { $subq = $subq->whereIn('original_language', $request->original_languages); }
        // Year Filters
        if($request->min_year) { $subq = $subq->where('series.first_air_date', '>=', Carbon::create($request->min_year,1,1)); }
        if($request->max_year) { $subq = $subq->where('series.first_air_date', '<=', Carbon::create($request->max_year,12,31)); }
        $qqSql = $subq->toSql();
        $return_val = DB::table('series')
        ->join(
            DB::raw('(' . $qqSql. ') AS ss'),
            function($join) use ($subq) { $join->on('series.id', 'ss.id')->addBinding($subq->getBindings()); }
        )
        ->leftjoin('series_rateds', function ($join) { $join->on('series_rateds.series_id', 'series.id')->where('series_rateds.user_id', Auth::id()); })
        ->leftjoin('series_laters', function ($join) { $join->on('series_laters.series_id', 'series.id')->where('series_laters.user_id', Auth::id()); })
        ->leftjoin('series_bans', function ($join) use ($request) { $join->on('series_bans.series_id', 'series.id')->where('series_bans.user_id', Auth::id()); })
        ->select(
            'series.original_name',
            'ss.point',
            'ss.count',
            'ss.percent',
            'ss.p2',
            'ss.id',
            'series.vote_average',
            'series.vote_count',
            'series.first_air_date',
            'series.en_name as name',
            'series.en_backdrop_path as backdrop_path',
            'series.en_poster_path as poster_path',
            'series_rateds.rate as rate_code',
            'series_laters.id as later_id',
            'series_bans.id as ban_id'
        );
        // User Hide Filter
        if($request->hide && !in_array('None', $request->hide)) {
            if(in_array('Watch Later', $request->hide)) $return_val = $return_val->whereNull('series_laters.id');
            if(in_array('Already Seen', $request->hide)) $return_val = $return_val->where(function ($query) { $query->where('series_rateds.rate', 0)->orWhereNull('series_rateds.rate'); });
            if(in_array('Hidden', $request->hide)) $return_val = $return_val->whereNull('series_bans.id');
        }
        // Sorting
        if($request->sort === 'Match Score') { $return_val = $return_val->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc'); }
        elseif($request->sort == 'Newest') { $return_val = $return_val->orderBy('first_air_date', 'desc')->orderBy('percent', 'desc')->orderBy('vote_average', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Top Rated') { $return_val = $return_val->orderBy('vote_average', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc')->orderBy('popularity', 'desc'); }
        else if($request->sort == 'Most Popular') { $return_val = $return_val->orderBy('popularity', 'desc')->orderBy('point', 'desc')->orderBy('percent', 'desc'); }
        if($request->genre_combination) {
            $return_val = $return_val->join('series_genres', 'series_genres.series_id', 'series.id')
            ->whereIn('genre_id', $request->genre_combination)
            ->groupBy('series.id')
            ->havingRaw('COUNT(series.id)='.count($request->genre_combination));
        }

        return $return_val->paginate(Auth::User()->pagination);
    }
}
