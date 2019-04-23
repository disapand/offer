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

    // 客户信息操作的路由
    Route::get('customs', 'API\CustomController@index');
    Route::get('custom/{nameOrCompany}', 'API\CustomController@search')->where('nameOrCompany', '[^\d]+');
    Route::get('custom/{custom}', 'API\CustomController@show');
    Route::delete('custom/{custom}', 'API\CustomController@destroy');
    Route::post('custom', 'API\CustomController@store');
    Route::post('custom/{custom}', 'API\CustomController@update');

    // 账号信息操作路由
    Route::delete('profile/{user}', 'API\AuthController@destroy');
    Route::get('profile', 'API\AuthController@profile');
    Route::get('profile/{user}', 'API\AuthController@show');
    Route::put('profile/{user}', 'API\AuthController@update');
    Route::get('profiles', 'API\AuthController@profiles');
    Route::post('profile', 'API\AuthController@store');

    // 价目操作相关路由
    Route::get('prices', 'API\PriceController@index');
    Route::get('price/{name}', 'API\PriceController@search')->where('name', '[^\d]+');
    Route::get('price/{price}', 'API\PriceController@show');
    Route::delete('price/{price}', 'API\PriceController@destroy');
    Route::post('price', 'API\PriceController@store');
    Route::post('price/{price}', 'API\PriceController@update');

    //报价单相关操作
    Route::get('/papers', 'API\PaperController@index');
    Route::get('/paperSearch/{company}', 'API\PaperController@query');
    Route::get('/paper/{paper}', 'API\PaperController@show');
    Route::post('/paper', 'API\PaperController@store');
    Route::delete('/paper/{paper}', 'API\PaperController@destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
