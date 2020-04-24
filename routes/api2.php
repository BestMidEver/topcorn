<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API2 Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return Auth::user();
    });
    
    Route::post('/logout', 'Api2\Auth\AuthController@logout');
});

Route::post('/login', 'Api2\Auth\AuthController@login');
Route::post('/register', 'Api2\Auth\AuthController@register');