<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('user')->group(function () {
    Route::post('create', 'UserController@create');
    Route::post('list', 'UserController@index');
    Route::post('detail', 'UserController@detail');
    Route::post('update', 'UserController@update');
    Route::post('delete', 'UserController@delete');
});

Route::prefix('day_event')->group(function () {
    Route::post('create', 'DayEventController@create');
    Route::post('list', 'DayEventController@index');
    Route::post('detail', 'DayEventController@detail');
    Route::post('update', 'DayEventController@update');
    Route::post('delete', 'DayEventController@delete');
});

Route::prefix('user_relation')->group(function () {
    Route::post('create', 'UserRelationController@create');
    Route::post('list', 'UserRelationController@index');
    Route::post('detail', 'UserRelationController@detail');
    Route::post('update', 'UserRelationController@update');
    Route::post('delete', 'UserRelationController@delete');
});

Route::prefix('ds/{item_type}')->group(function () {
    Route::post('create', 'ItemController@create');
    Route::post('list', 'ItemController@index');
    Route::post('detail', 'ItemController@detail');
    Route::post('update', 'ItemController@update');
    Route::post('delete', 'ItemController@delete');
});




