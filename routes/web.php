<?php

use App\Jobs\RefreshSiteMapJob;
use App\Jobs\SuckDataJob;
use App\User;
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

//Route::redirect('/', '/home');



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
////////////////////////////////////////// HOOKS /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('home', 'PageControllers\DonationController@whatmovieshouldiwatch')->middleware('blog_if_not_logged_in');//GUEST
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// HOOKS /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// OTHER PAGES ////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('/{lang?}', 'PageControllers\homeController@home')
	->where('lang', config('constants.supported_languages.for_web_php'))
	->middleware('blog_if_not_logged_in');//PUBLIC

Route::get('person/{id}/{lang?}', 'PageControllers\personController@person')->middleware('id_dash_personname')
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
Route::get('api/get_movie_lists/{movie}','PageControllers\movieController@get_movie_lists');
Route::post('api/send_movie_to_user','PageControllers\movieController@send_movie_to_user');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// MOVIE PAGE (PULBIC) ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SERIES PAGE (PULBIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('series/{id}/{lang?}/{secondary_lang?}', 'PageControllers\seriesController@series')->middleware('id_dash_seriesname')
	->where('lang', config('constants.supported_languages.for_web_php'));
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SERIES PAGE (PULBIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// LIST PAGE (PULBIC) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('list/{id}', 'PageControllers\listController@list')->middleware('id_dash_listname');
Route::get('createlist/{id?}', 'PageControllers\listController@create_list')->middleware('id_dash_listname');

Route::get('deletelist/{id}', 'PageControllers\listController@delete_list');
Route::get('api/likelist/{id}', 'PageControllers\listController@like_list');
Route::get('api/unlikelist/{id}', 'PageControllers\listController@unlike_list');
Route::post('createlist', 'PageControllers\listController@post_createlist');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// LIST PAGE (PULBIC) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// RECOMMENDATIONS PAGE (PUBLIC) ///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('recommendations/{user?}', 'PageControllers\recommendationsController@recommendations');

Route::get('api/get_last_parties','ApiControllers\SearchController@get_last_parties');
Route::get('api/remove_from_parties/{user}','ApiControllers\SearchController@remove_from_parties');
Route::get('api/add_to_parties/{user}','ApiControllers\SearchController@add_to_parties');
Route::post('api/get_top_rateds/{lang?}','PageControllers\recommendationsController@get_top_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_series_top_rateds/{lang?}','PageControllers\recommendationsController@get_series_top_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_pemosu/{lang?}','PageControllers\recommendationsController@get_pemosu')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_series_pemosu/{lang?}','PageControllers\recommendationsController@get_series_pemosu')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::post('api/get_momosu','PageControllers\recommendationsController@get_momosu');
Route::post('api/get_series_momosu','PageControllers\recommendationsController@get_series_momosu');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// RECOMMENDATIONS PAGE (PUBLIC) ///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// MAIN PAGE (PUBLIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('main/{lang?}', 'PageControllers\mainController@main')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_legendary_garbage_movies/{mode}/{users}/{sort}','PageControllers\mainController@get_legendary_garbage_movies');
Route::get('api/get_legendary_garbage_series/{mode}/{users}/{sort}','PageControllers\mainController@get_legendary_garbage_series');
Route::get('api/get_airing_series/{mode}','PageControllers\mainController@get_airing_series');
Route::get('api/get_popular_people/{mode}','PageControllers\mainController@get_popular_people');
Route::get('api/get_popular_users/{mode}/{f_following}','PageControllers\mainController@get_popular_users');
Route::get('api/get_popular_lists/{mode}/{f_following}','PageControllers\mainController@get_popular_lists');
Route::get('api/get_popular_reviews/{mode}/{f_following}','PageControllers\mainController@get_popular_reviews');
//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// MAIN PAGE (PUBLIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SEARCH PAGE (AUTH) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('search/{lang?}', 'PageControllers\searchController@search')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_pluck_id/{mode}','ApiControllers\SearchController@get_pluck_id');
Route::get('api/search_lists/{text}','ApiControllers\SearchController@search_lists');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SEARCH PAGE (AUTH) /////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// NOTIFICATIONS PAGE (AUTH) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('notifications/{lang?}', 'PageControllers\NotificationsController@notifications')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/set_seen/{notification_id}/{is_seen}', 'PageControllers\NotificationsController@set_seen');

Route::get('create_notification/{id?}', 'PageControllers\CustomNotificationController@create_notification');
Route::post('create_notification', 'PageControllers\CustomNotificationController@post_create_notification');
Route::get('api/get_notifications/{page_mode}/{page}', 'PageControllers\NotificationsController@get_notifications');
Route::get('api/get_notification_button', 'PageControllers\NotificationsController@get_notification_button');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// NOTIFICATIONS PAGE (AUTH) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// PROFILE PAGE (PUBLIC) ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('profile/{user}/{lang?}', 'PageControllers\ProfileController@profile')->middleware('id_dash_username')
	->where('lang', config('constants.supported_languages.for_web_php'));

Route::get('api/get_rateds/{rate}/{user}/{lang}','PageControllers\ProfileController@get_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_series_rateds/{rate}/{user}/{lang}','PageControllers\ProfileController@get_series_rateds')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_laters/{user}/{lang}','PageControllers\ProfileController@get_laters')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_series_laters/{mode}/{user}/{lang}','PageControllers\ProfileController@get_series_laters')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_bans/{user}/{lang}','PageControllers\ProfileController@get_bans')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_series_bans/{user}/{lang}','PageControllers\ProfileController@get_series_bans')
	->where('lang', config('constants.supported_languages.for_web_php'));
Route::get('api/get_reviews/{user}','PageControllers\ProfileController@get_reviews');
Route::get('api/get_follows/{user}/{mode}','PageControllers\ProfileController@get_follows');
Route::get('api/get_lists/{list_mode}/{user}','PageControllers\ProfileController@get_lists');
Route::apiResource('api/follow','ApiControllers\FollowController');
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
Route::get('account/notifications-emails', 'PageControllers\accountController@notifications_emails');

Route::post('account', 'PageControllers\accountController@change_profile');
Route::post('account/password', 'PageControllers\accountController@change_password');
Route::post('account/interface', 'PageControllers\accountController@change_interface');
Route::post('account/notifications-emails', 'PageControllers\accountController@change_notifications_emails');
Route::get('theme/{mode?}', 'PageControllers\accountController@theme');
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
Route::get('api/get_quick_rate_series/{lang}','ApiControllers\RatedController@get_quick_rate_series');
Route::get('api/get_watched_movie_number','ApiControllers\RatedController@get_watched_movie_number');
Route::get('api/suck_movie/{movie_id}','ApiControllers\JobController@suck_movie');
Route::get('api/suck_series/{series_id}','ApiControllers\JobController@suck_series');
Route::post('api/tooltip','ApiControllers\LevelController@tt_manipulate');
Route::apiResource('api/series_bans','ApiControllers\SeriesBanController');
Route::apiResource('api/series_laters','ApiControllers\SeriesLaterController');
Route::apiResource('api/series_rateds','ApiControllers\SeriesRatedController');
Route::apiResource('api/series_seens','ApiControllers\SeriesSeenController');
Route::post('api/destroy_review','ApiControllers\ReviewController@destroy_review');
Route::post('api/show_reviews','ApiControllers\ReviewController@show_reviews');
Route::apiResource('api/reviews','ApiControllers\ReviewController');
Route::apiResource('api/review_like','ApiControllers\ReviewLikeController');
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// API RATE (AUTH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('suckData', function(){
	SuckDataJob::dispatch()->onQueue("low");
	return 'sucking data.';
});
Route::get('refreshSitemap', function(){
	RefreshSiteMapJob::dispatch()->onQueue("high");
	return 'refreshing sitemaps.';
});
//Route::get('refreshSitemap','Architect\Architect@refreshSitemap');
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('test', function(){
	return dd(DB::table('users')
           	->where('users.when_automatic_notification', '>', 0)
            ->leftjoin('series_laters', function ($join) {
                $join->on('series_laters.user_id', '=', 'users.id')
                ->where('series_laters.series_id', '=', 1421);
            })
            ->leftjoin('series_rateds', function ($join) {
                $join->on('series_rateds.user_id', '=', 'users.id')
                ->where('series_rateds.series_id', '=', 1421)
                ->where('series_rateds.rate', '>', 3);
            })
            ->select('users.id as user_id', 'users.when_automatic_notification')
            ->get());
});
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////