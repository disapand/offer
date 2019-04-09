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
    Route::get('custom/{custom}', 'API\CustomController@show');
    Route::delete('custom/{custom}', 'API\CustomController@destroy');
    Route::post('custom', 'API\CustomController@store');
    Route::post('custom/{custom}', 'API\CustomController@update');
    Route::delete('profile/{user}', 'API\AuthController@destroy');
    Route::get('profile', 'API\AuthController@profile');
    Route::get('profile/{user}', 'API\AuthController@show');
    Route::put('profile/{user}', 'API\AuthController@update');
    Route::get('profiles', 'API\AuthController@profiles');
    Route::post('profile', 'API\AuthController@store');
    Route::get('prices', 'API\PriceController@index');
    Route::get('price/{name}', 'API\PriceController@search')->where('name', '[^\d]+');
    Route::get('price/{price}', 'API\PriceController@show');
    Route::delete('price/{price}', 'API\PriceController@destroy');
    Route::post('price', 'API\PriceController@store');
    Route::post('price/{price}', 'API\PriceController@update');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
