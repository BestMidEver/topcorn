<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API2 Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {
    // Search
    Route::get('/pluckId/interactedMoviesSeries', 'Api2\MergeController@pluckId');
    Route::get('/recentlyVisiteds', 'Api2\SearchController@recentlyVisiteds');
    Route::get('/clearRecentlyVisiteds/{type}', 'Api2\SearchController@clearRecentlyVisiteds');
    Route::get('/searchUser/{query}','Api2\SearchController@searchUser');

    // Rate
    Route::post('/rate/{type}', 'Api2\RateController@rateAssign');
    Route::get('/getUserReview/{type}/{objId}/{season?}/{episode?}', 'Api2\RateController@getUserReview');
    Route::post('/sendReview/{type}', 'Api2\RateController@sendReview');
    Route::post('/watchLater/{type}', 'Api2\RateController@watchLaterAssign');
    Route::post('/ban/{type}', 'Api2\RateController@banAssign');
    Route::post('/lastSeen', 'Api2\RateController@lastSeen');

    // QuickVote
    Route::get('/getQuickVote/{type}/{objId?}', 'Api2\QuickVoteController@getQuickVoteAssign');

    // Movie Series
    Route::get('/getMovieSeriesAllData/{type}/{objId}/{season?}/{episode?}', 'Api2\MovieSeriesController@getMovieSeriesDataAssign');
    //Route::get('/movieSeriesCardData/{type}/{objId}', 'Api2\MovieSeriesController@movieSeriesCardData');

    // Person
    Route::get('/getPersonAllData/{id}', 'Api2\PersonController@getPersonData');

    // User
    Route::post('/getUserAllData', 'Api2\UserController@getUserData');
    Route::get('/getUserDetailData/{id}', 'Api2\UserController@getUserDetails');
    
    // Review
    Route::get('/getReviewsData/{type}/{objId}', 'Api2\MovieSeriesController@reviewDataAssign');
    Route::get('/getPersonReviewsData/{objId}', 'Api2\PersonController@reviewData');
    Route::post('/likeReview', 'Api2\ReviewController@reviewLikeAssign');

    Route::post('/logout', 'Api2\Auth\AuthController@logout');
});

Route::post('/login', 'Api2\Auth\AuthController@login');
Route::post('/register', 'Api2\Auth\AuthController@register');