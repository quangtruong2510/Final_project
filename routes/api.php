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
    Route::get('/', 'DestinationController@getAllDestination');
    Route::post('/', 'DestinationController@createDestination');
    Route::put('/{id}', 'DestinationController@updateDestination');
    Route::delete('/{id}', 'DestinationController@deleteDestination');
    Route::get('/{id}', 'DestinationController@getDestinationById');
    Route::get('favourite/', 'DestinationController@getListFavouriteDestination');
    Route::put('favourite/{id}', 'DestinationController@addToFavouriteListDestination');
    Route::get('category/{id}', 'DestinationController@getDestinationByCategoryId');
});

Route::group([
    'middleware' => 'api', 'auth',
    'prefix' => 'category',
], function ($router) {
    Route::post('/', 'CategoryController@createCategory');
    Route::delete('/{id}', 'CategoryController@deleteCategoryById');
    Route::get('/', 'CategoryController@getListCategory');


});

