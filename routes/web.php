<?php

use App\Jobs\RefreshSitemapJob;
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
//////////////////////////////// RECOMMENDATIONS PAGE (PUBLIC) ///////////////////////////
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
//////////////////////////////// RECOMMENDATIONS PAGE (PUBLIC) ///////////////////////////
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
	return 'sucking data.';
});
Route::get('refreshSitemap', function(){
	RefreshSitemapJob::dispatch()->onQueue("low");
	$myfile = fopen("sitemap.xml", "w") or die("Unable to open file!");
    $xml = '<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
<url> <loc>https://topcorn.io/recommendations</loc> <lastmod>'.substr(Carbon::now(), 0, 10).'</lastmod> <changefreq>weekly</changefreq> <priority>1</priority> </url>
<url> <loc>https://topcorn.io/home</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>1</priority> </url>
<url> <loc>https://topcorn.io/register</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.50</priority> </url>
<url> <loc>https://topcorn.io/login</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.50</priority> </url>
<url> <loc>https://topcorn.io/faq</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.80</priority> </url>
<url> <loc>https://topcorn.io/privacy-policy</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
<url> <loc>https://topcorn.io/donation</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
<url> <loc>https://topcorn.io/password/reset</loc> <lastmod>2018-03-19</lastmod> <changefreq>monthly</changefreq> <priority>0.60</priority> </url>
	';

    $movies = DB::table('movies')
    ->select(
        'movies.id',
        'movies.original_title',
        'movies.updated_at'
    )
    ->get();
    foreach ($movies as $movie) {
    	$xml = $xml.'<url> <loc>https://topcorn.io/movie/'.$movie->id.'-'.str_replace(array(' ','/','?','#'), '-', $movie->original_title).'</loc> <lastmod>'.substr($movie->updated_at, 0, 10).'</lastmod> <changefreq>weekly</changefreq> <priority>0.80</priority> </url> 
';
	}

    $xml = $xml . '</urlset> ';
    fwrite($myfile, $xml);
    fclose($myfile);
	return 'refreshing sitemap.';
});
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// SUCK DATA (ONLY ARCHITECT) /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('test', function(){
});
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// TEST ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////