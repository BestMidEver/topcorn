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
    Route::get('/recenltyVisiteds', 'Api2\SearchController@recenltyVisiteds');
    Route::get('/clearRecentlyVisiteds/{type}', 'Api2\SearchController@clearRecentlyVisiteds');
    Route::get('/searchUser/{query}','Api2\SearchController@searchUser');

    // Rate
    Route::post('/rate/{type}', 'Api2\RateController@rateAssign');
    Route::get('/getUserReview/{type}/{objId}', 'Api2\RateController@getUserReview');

    Route::post('/logout', 'Api2\Auth\AuthController@logout');
});

Route::post('/login', 'Api2\Auth\AuthController@login');
Route::post('/register', 'Api2\Auth\AuthController@register');