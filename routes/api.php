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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    // 'namespace' => 'App\Http\Controllers'

], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});

Route::group([
    'middleware' => 'api', 'auth',
    'prefix' => 'destination',
], function ($router) {
    Route::post('create', 'DestinationController@createDestination');
    Route::delete('delete/{id}', 'DestinationController@deleteDestination');
    Route::put('update/{id}', 'DestinationController@updateDestination');
    Route::get('favourite/', 'DestinationController@getListFavouriteDestination');
    Route::get('/', 'DestinationController@getAllDestination');
    Route::get('/{id}', 'DestinationController@getDestinationById');
    Route::put('favourite/{id}', 'DestinationController@addToFavouriteListDestination');
    Route::get('category/', 'DestinationController@getListCategories');


});

