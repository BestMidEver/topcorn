<?php

use App\Jobs\SuckDataJob;
use App\Jobs\SuckMovieJob;
use App\Model\Genre;
use App\Model\Movie;
use App\Model\Recommendation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::redirect('/', '/home');



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SOCIAL LOGIN(GUEST) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('log_in/{social}/{remember_me}','Auth\LoginController@socialLogin')
	->where('social','twitter|facebook|linkedin|google|github');

Route::get('login/{social}/callback','Auth\LoginController@handleProviderCallback')
	->where('social','twitter|facebook|linkedin|google|github');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SOCIAL LOGIN(GUEST) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// OTHER PAGES ////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('home/{lang?}', 'PageControllers\homeController@home')
	->where('lang', config('constants.supported_languages.for_web_php'));//GUEST

Route::get('person/{id}/{lang?}', 'PageControllers\personController@person')
	->where('lang', config('constants.supported_languages.for_web_php'));//AUTH

Route::get('donation/{lang?}', 'PageControllers\DonationController@donate')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC
Route::get('change_insta_language/{lang}', 'PageControllers\DonationController@change_insta_language')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC

Route::get('privacy-policy/{lang?}', 'PageControllers\PrivacypolicyController@privacypolicy')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC

Route::get('faq/{lang?}', 'PageControllers\FaqController@faq')
	->where('lang', config('constants.supported_languages.for_web_php'));//PUBLIC

Route::get('not-found', function () {
    return view('errors.404');
});//PUBLIC
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// OTHER PAGES ////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// MOVIE PAGE (PULBIC) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('movie/{id}/{lang?}/{secondary_lang?}', 'PageControllers\movieController@movie')->middleware('id_dash_moviename')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_user_movie_record/{movie}','PageControllers\movieController@get_user_movie_record');//IMPLEMENT AUTH
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// MOVIE PAGE (PULBIC) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// RECOMMENDATIONS PAGE (AUTH) ////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('recommendations/{user?}', 'PageControllers\recommendationsController@recommendations');

Route::get('api/get_last_parties','ApiControllers\SearchController@get_last_parties');
Route::get('api/remove_from_parties/{user}','ApiControllers\SearchController@remove_from_parties');
Route::get('api/add_to_parties/{user}','ApiControllers\SearchController@add_to_parties');
Route::post('api/get_top_rateds/{tab}/{lang?}','PageControllers\recommendationsController@get_top_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_pemosu/{lang?}','PageControllers\recommendationsController@get_pemosu')
	->where('lang', config('constants.supported_languages.for_web_php'));
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// RECOMMENDATIONS PAGE (AUTH) ////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SEARCH PAGE (AUTH) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('search/{lang?}', 'PageControllers\searchController@search')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_pluck_id','ApiControllers\SearchController@get_pluck_id');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SEARCH PAGE (AUTH) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// PROFILE PAGE (PUBLIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('profile/{user}/{lang?}', 'PageControllers\ProfileController@profile')->middleware('id_dash_username')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_rateds/{rate}/{user}/{lang}','PageControllers\ProfileController@get_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_laters/{user}/{lang}','PageControllers\ProfileController@get_laters')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_bans/{user}/{lang}','PageControllers\ProfileController@get_bans')
	->where('lang', config('constants.supported_languages.for_web_php'));
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// PROFILE PAGE (PUBLIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SETTINGS PAGE (AUTH) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('account', 'PageControllers\accountController@account');
Route::get('account/password/{lang?}', 'PageControllers\accountController@password')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('account/interface/{lang?}', 'PageControllers\accountController@interface')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::post('account', 'PageControllers\accountController@change_profile');
Route::post('account/password', 'PageControllers\accountController@change_password');
Route::post('account/interface', 'PageControllers\accountController@change_interface');
Route::get('api/get_cover_pics/{lang}','PageControllers\accountController@get_cover_pics')
	->where('lang', config('constants.supported_languages.for_web_php'));
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// SETTINGS PAGE (AUTH) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// API RATE (AUTH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::apiResource('api/bans','ApiControllers\BanController');
Route::apiResource('api/laters','ApiControllers\LaterController');
Route::apiResource('api/rateds','ApiControllers\RatedController');
Route::get('api/search_users/{text?}','ApiControllers\SearchController@search_users');
Route::get('api/get_quick_rate/{lang}','ApiControllers\RatedController@get_quick_rate');
Route::get('api/get_watched_movie_number','ApiControllers\RatedController@get_watched_movie_number');
Route::post('api/tooltip','ApiControllers\LevelController@tt_manipulate');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// API RATE (AUTH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('suckData', function(){
	//SuckDataJob::dispatch()->onQueue("low");
	return 'it\'s been started.';
});
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('test', function(){
	$start = microtime(true);

	if(Auth::User()->hover_title_language == 0){
	    $hover_title = Auth::User()->secondary_lang.'_title';
	}else{
	    $hover_title = 'original_title';
	}

	$subq = DB::table('rateds')
	->whereIn('rateds.user_id', [7])
	->where('rateds.rate', '>', 0)
	->leftjoin('recommendations', 'recommendations.movie_id', '=', 'rateds.movie_id')
	->join('movies', 'movies.id', '=', 'recommendations.this_id')
	/*->leftjoin('rateds as r2', function ($join){
	    $join->on('r2.movie_id', '=', 'movies.id')
	    ->whereIn('r2.user_id', [7]);
	})*/
	->select(
	    'recommendations.this_id as id',
	    DB::raw('sum((rateds.rate-3)*recommendations.is_similar) DIV '.count([7]).' AS point'),
	    DB::raw('COUNT(recommendations.this_id) as count'),
	    DB::raw('sum(rateds.rate)*20 DIV COUNT(recommendations.this_id) as percent'),
	    DB::raw('sum(rateds.rate*recommendations.is_similar)*4 DIV COUNT(recommendations.this_id) as p2')
	)
	->groupBy('movies.id');
	//->havingRaw('sum((rateds.rate-3)*recommendations.is_similar) DIV '.count([7]).' > 7 AND sum(rateds.rate)*20 DIV COUNT(recommendations.this_id) > 75 AND sum(IF(r2.id IS NULL OR r2.rate = 0, 0, 1)) = 0');

	if([] != [])
	{
	    $subq = $subq->whereIn('original_language', []);
	}

	if(1917 != 1917)
	{
	    $subq = $subq->where('movies.release_date', '>=', Carbon::create(1917,1,1));
	}

	if(2018 != 2018)
	{
	    $subq = $subq->where('movies.release_date', '<=', Carbon::create(2018,12,31));
	}

	$qqSql = $subq->toSql();

/////////////////////////////////////////////////////////

	$subq_2 = DB::table('movies')
	->join(
	    DB::raw('(' . $qqSql. ') AS ss'),
	    function($join) use ($subq) {
	        $join->on('movies.id', '=', 'ss.id')
	        ->addBinding($subq->getBindings());  
	    }
	)
	->rightjoin('movies as m2', 'm2.id', '=', 'movies.id')
	->select(
        'm2.id',
        'ss.point',
        'ss.count',
        'ss.percent',
        'ss.p2'
    )
	->where('m2.vote_count', '>', Auth::User()->min_vote_count*5)
    ->where('m2.vote_average', '>', config('constants.suck_page.min_vote_average'));


	if([53,878] != [])
	{
	    $subq_2 = $subq_2->join('genres', 'genres.movie_id', '=', 'm2.id')
	    ->whereIn('genre_id', [53,878])
	    ->groupBy('m2.id')
	    ->havingRaw('COUNT(m2.id)='.count([53,878]));
	};

	$qqSql_2 = $subq_2->toSql();

/////////////////////////////////////////////////////////

	$return_val = DB::table('movies')
	->join(
	    DB::raw('(' . $qqSql_2. ') AS ss'),
	    function($join) use ($subq_2) {
	        $join->on('movies.id', '=', 'ss.id')
	        ->addBinding($subq_2->getBindings());  
	    }
	)
	->leftjoin('rateds', function ($join) {
	    $join->on('rateds.movie_id', '=', 'm2.id')
	    ->whereIn('rateds.user_id', [7]);
	})
	->leftjoin('laters', function ($join) {
	    $join->on('laters.movie_id', '=', 'm2.id')
	    ->where('laters.user_id', '=', Auth::user()->id);
	})
	->leftjoin('bans', function ($join){
	    $join->on('bans.movie_id', '=', 'm2.id')
	    ->whereIn('bans.user_id', [7]);
	})
	->select(
        'movies.id',
        'movies.'.$hover_title.' as original_title',
        'ss.point',
        'ss.count',
        'ss.percent',
        'ss.p2',
        'movies.vote_average',
        'movies.vote_count',
        'movies.release_date',
        'movies.'.Auth::User()->lang.'_title as title',
        'movies.'.Auth::User()->lang.'_poster_path as poster_path',
        'rateds.id as rated_id',
        'rateds.rate as rate_code',
        'laters.id as later_id',
        'bans.id as ban_id'
    )
    ->groupBy('m2.id')
    ->havingRaw('sum(IF(rateds.id IS NULL OR rateds.rate = 0, 0, 1)) = 0 AND sum(IF(bans.id IS NULL, 0, 1)) = 0')
    ->orderBy('movies.vote_average', 'desc');
    





	
    
    /*->orderBy('point', 'desc')
    ->orderBy('p2', 'desc')*/


	return [$return_val->paginate(Auth::User()->pagination), microtime(true) - $start];
});
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////