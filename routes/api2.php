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
    Route::post('/follow', 'Api2\RateController@followAssign');
    Route::post('/notifiedBy/{type}', 'Api2\RateController@notifiedByAssign'); //Bumper to bumper

    // QuickVote
    Route::get('/getQuickVote/{type}/{objId?}', 'Api2\QuickVoteController@getQuickVoteAssign');

    // Movie Series
    Route::get('/getMovieSeriesAllData/movie/{id}', 'Api2\MovieSeriesController@getMovieData')->middleware('UpdateRecents:movie');
    Route::get('/getMovieSeriesAllData/series/{id}/{season?}/{episode?}', 'Api2\MovieSeriesController@getSeriesData')->middleware('UpdateRecents:series');
    Route::get('/getShareObjectModalUsers/{type}/{objId}', 'Api2\ShareController@getShareObjectModalUsers');
    Route::post('/shareObjects', 'Api2\SettingsController@shareObjects');

    // Person
    Route::get('/getPersonAllData/{id}', 'Api2\PersonController@getPersonData')->middleware('UpdateRecents:person');

    // User
    Route::post('/getUserAllData', 'Api2\UserController@getUserData')->middleware('UpdateRecents:user');
    Route::get('/getSimpleUserData', 'Api2\UserController@getSimpleUserData');
    Route::get('/getUserDetailData/{id}', 'Api2\UserController@getUserDetails');
    Route::post('/getUserInteractionSet', 'Api2\UserController@getUserInteractionSet');
    Route::get('/getCoverPics', 'Api2\UserController@getCoverPics');
    
    // Settings
    Route::post('/setUser', 'Api2\SettingsController@settingsAssign');
    
    // Discover
    Route::post('/discover', 'Api2\DiscoverController@discoverAssign');

    // Notifications
    Route::get('/notifications', 'Api2\NotificationController@getNotificationButton');
    Route::post('/notifications', 'Api2\NotificationController@getNotifications');
    Route::post('/changeNotificationMode', 'Api2\NotificationController@changeNotificationMode');
    
    // Review
    Route::get('/getReviewsData/{type}/{objId}', 'Api2\MovieSeriesController@reviewDataAssign');
    Route::get('/getPersonReviewsData/{objId}', 'Api2\PersonController@reviewData');
    Route::post('/likeReview', 'Api2\ReviewController@reviewLikeAssign');

    Route::post('/logout', 'Api2\Auth\AuthController@logout');
});

Route::post('/login', 'Api2\Auth\AuthController@login');
Route::post('/register', 'Api2\Auth\AuthController@register');