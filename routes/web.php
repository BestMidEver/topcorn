<?php

use App\Jobs\SuckDataJob;
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
Route::get('login/{social}','Auth\LoginController@socialLogin')
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
Route::get('change_insta_language/{lang}', 'PageControllers\accountController@change_insta_language')
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
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// API RATE (AUTH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('suckData', function(){
	SuckDataJob::dispatch()->onQueue("low");
	return 'it\'s been started.';
});
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('test', function(){
        if(0 == 0){
            $hover_title = 'en'.'_title';
        }else{
            $hover_title = 'original_title';
        }

        $return_val = DB::table('rateds')
        ->whereIn('rateds.user_id', [7])
        ->where('rateds.rate', '<>', 3)
        ->leftjoin('recommendations', 'recommendations.movie_id', '=', 'rateds.movie_id')
        ->join('movies', 'movies.id', '=', 'recommendations.this_id')
        ->leftjoin('rateds as r2', function ($join){
            $join->on('r2.movie_id', '=', 'movies.id')
            ->whereIn('r2.user_id', [7]);
        })
        ->leftjoin('laters', function ($join) {
            $join->on('laters.movie_id', '=', 'movies.id')
            ->where('laters.user_id', '=', 7);
        })
        //->where('laters.id', '=', null)
        ->leftjoin('bans', function ($join){
            $join->on('bans.movie_id', '=', 'movies.id')
            ->whereIn('bans.user_id', [7]);
        })
        ->where('bans.id', '=', null)
        ->select(
            'recommendations.this_id as id',
            'recommendations.movie_id as mother_movie_id',
            'movies.'.$hover_title.' as original_title',
            DB::raw('sum(IF(recommendations.is_similar, 2, 7)*(rateds.rate-3.8))*movies.vote_average AS point'),
            DB::raw('COUNT(*) as count'),
            'movies.vote_average',
            'movies.release_date',
            'movies.'.'tr'.'_title as title',
            'movies.'.'tr'.'_poster_path as poster_path',
            'r2.id as rated_id',
            'r2.rate as rate_code',
            'laters.id as later_id',
            'bans.id as ban_id'
        )
        ->groupBy('movies.id')
        //->havingRaw('sum(IF(recommendations.is_similar, 2, 7)*(rateds.rate-3.8)) > 4 AND sum(IF(r2.id IS NULL OR r2.rate = 0, 0, 1)) = 0')
        ->orderBy('point', 'desc');

        if(["18"] != []){
            //$return_val = $return_val->join('genres', 'genres.movie_id', '=', 'movies.id');
            //->whereIn('genre_id', ["18"]);
        }

        /*if(["en"] != [])
        {
            $return_val = $return_val->whereIn('original_language', ["en"]);
        }

        if(2005 != 1917)
        {
            $return_val = $return_val->where('movies.release_date', '>=', Carbon::create(2005,1,1));
        }

        if(2018 != 2018)
        {
            $return_val = $return_val->where('movies.release_date', '<=', Carbon::create(2018,12,31));
        }*/

        return $return_val->paginate(24);
});
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////