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
Route::get('api/get_watched_movie_number','ApiControllers\RatedController@get_watched_movie_number');
Route::post('api/level','ApiControllers\LevelController@level_manipulate');
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
    $is_recent = Movie::where('id', 77)
    ->where('updated_at', '>', Carbon::now()->subHours(30)->toDateTimeString())
    ->first();
    if($is_recent) return;

    if(true){
        $movie = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/77?api_key='.config('constants.api_key').'&language=en&append_to_response=recommendations%2Csimilar'), true);
        Recommendation::where(['movie_id' => 77])->delete();
        for ($k=0; $k < count($movie['similar']['results']); $k++) {
            $temp = $movie['similar']['results'][$k];
            SuckMovieJob::dispatch($temp['id'], false)->onQueue("high");
            if($temp['vote_count'] < config('constants.suck_page.min_vote_count') || $temp['vote_average'] < config('constants.suck_page.min_vote_average')) continue;
            $recommendation = new Recommendation;
            $recommendation->id = 77*10000000 + $temp['id'];
            $recommendation->this_id = $temp['id'];
            $recommendation->movie_id = 77;
            $recommendation->is_similar = true;
            $recommendation->save();
        }
        for ($k=0; $k < count($movie['recommendations']['results']); $k++) {
            $temp = $movie['recommendations']['results'][$k];
            SuckMovieJob::dispatch($temp['id'], false)->onQueue("high");
            if($temp['vote_count'] < config('constants.suck_page.min_vote_count') || $temp['vote_average'] < config('constants.suck_page.min_vote_average')) continue;
            Recommendation::updateOrCreate(
                ['this_id' => $temp['id'], 'movie_id' => 77],
                ['id' => 77*10000000 + $temp['id'],
                'is_similar' => false,]
            );
        }
        $movie_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/77?api_key='.config('constants.api_key').'&language=tr'), true);
        $movie_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/77?api_key='.config('constants.api_key').'&language=hu'), true);
        Movie::updateOrCreate(
            ['id' => $movie['id']],
            ['original_title' => $movie['original_title'],
            'vote_average' => $movie['vote_average'],
            'original_language' => $movie['original_language'],
            'release_date' => new Carbon($movie['release_date']),
            'popularity' => $movie['popularity'],
            'en_title' => $movie['title'],
            'tr_title' => $movie_tr['title'],
            'hu_title' => $movie_hu['title'],
            'en_poster_path' => $movie['poster_path'],
            'tr_poster_path' => $movie_tr['poster_path'],
            'hu_poster_path' => $movie_hu['poster_path'],
            'en_cover_path' => $movie['backdrop_path'],
            'tr_cover_path' => $movie_tr['backdrop_path'],
            'hu_cover_path' => $movie_hu['backdrop_path'],
            'vote_count' => $movie['vote_count']]
        );
        Genre::where(['movie_id' => 77])->delete();
        for ($k=0; $k < count($movie['genres']); $k++) { 
            $genre = new Genre;
            $genre->id = $movie['id']*10000000 + $movie['genres'][$k]['id'];
            $genre->movie_id = $movie['id'];
            $genre->genre_id = $movie['genres'][$k]['id'];
            $genre->save();
        }
    }else{
        $movie = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/77?api_key='.config('constants.api_key').'&language=en'), true);
        $movie_tr = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/77?api_key='.config('constants.api_key').'&language=tr'), true);
        $movie_hu = json_decode(file_get_contents('https://api.themoviedb.org/3/movie/77?api_key='.config('constants.api_key').'&language=hu'), true);
        Movie::updateOrCreate(
            ['id' => $movie['id']],
            ['original_title' => $movie['original_title'],
            'vote_average' => $movie['vote_average'],
            'original_language' => $movie['original_language'],
            'release_date' => new Carbon($movie['release_date']),
            'popularity' => $movie['popularity'],
            'en_title' => $movie['title'],
            'tr_title' => $movie_tr['title'],
            'hu_title' => $movie_hu['title'],
            'en_poster_path' => $movie['poster_path'],
            'tr_poster_path' => $movie_tr['poster_path'],
            'hu_poster_path' => $movie_hu['poster_path'],
            'en_cover_path' => $movie['backdrop_path'],
            'tr_cover_path' => $movie_tr['backdrop_path'],
            'hu_cover_path' => $movie_hu['backdrop_path'],
            'vote_count' => $movie['vote_count']]
        );
        Genre::where(['movie_id' => 77])->delete();
        for ($k=0; $k < count($movie['genres']); $k++) { 
            $genre = new Genre;
            $genre->id = $movie['id']*10000000 + $movie['genres'][$k]['id'];
            $genre->movie_id = $movie['id'];
            $genre->genre_id = $movie['genres'][$k]['id'];
            $genre->save();
        }
    }

}