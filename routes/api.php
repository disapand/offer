<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'API\AuthController@login');
    Route::post('logout', 'API\AuthController@logout');
});

Route::group(['middleware' => 'refresh.token'], function () {
    Route::get('customs', 'API\CustomController@index');
    Route::post('custom', 'API\CustomController@store');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
