<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API2 Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
