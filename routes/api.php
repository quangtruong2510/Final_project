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
    // http://127.0.0.1:8000/api/destination/schedule/18
    Route::get('schedule', 'DestinationController@getListScheduleDestination');

    // http://127.0.0.1:8000/api/destination
    Route::get('', 'DestinationController@getAllDestination');

    // https://save-location-final.herokuapp.com/api/category
    Route::post('', 'DestinationController@createDestination');

    // http://127.0.0.1:8000/api/destination/favourite
    Route::get('favourite', 'DestinationController@getListFavouriteDestination');

    // http://127.0.0.1:8000/api/destination/{id}
    Route::put('/{id}', 'DestinationController@updateDestination');

    // http://127.0.0.1:8000/api/destination/{id}
    Route::delete('/{id}', 'DestinationController@deleteDestination');

    // http://127.0.0.1:8000/api/destination/{id}
    Route::get('/{id}', 'DestinationController@getDestinationById');
    
    // http://127.0.0.1:8000/api/destination/favourite/18
    Route::put('favourite/{id}', 'DestinationController@addToFavouriteListDestination');

    // http://127.0.0.1:8000/api/destination/category/1
    Route::get('category/{id}', 'DestinationController@getDestinationByCategoryId');

    // http://127.0.0.1:8000/api/destination/schedule/add/18
    Route::put('schedule/add/{id}', 'DestinationController@addToScheduleListDestination');

    // http://127.0.0.1:8000/api/destination/schedule/delete/18
    Route::put('schedule/delete/{id}', 'DestinationController@deleteDestinationFromListSchedule');

    // http://127.0.0.1:8000/api/destination/schedule/delete
    Route::put('schedule/delete', 'DestinationController@deleteScheduleList');

    // http://127.0.0.1:8000/api/destination/schedule/delete
    Route::put('schedule/complete', 'DestinationController@completecheduleList');

    // http://127.0.0.1:8000/api/destination/schedule/submit/18
    Route::put('schedule/submit/{id}', 'DestinationController@completeSchedule');

});

Route::group([
    'middleware' => 'api', 'auth',
    'prefix' => 'category',
], function ($router) {
    
    // https://save-location-final.herokuapp.com/api/category
    Route::post('/', 'CategoryController@createCategory');

    Route::delete('/{id}', 'CategoryController@deleteCategoryById');

    // https://save-location-final.herokuapp.com/api/category
    Route::get('/', 'CategoryController@getListCategory');
});

