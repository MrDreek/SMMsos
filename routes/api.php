<?php

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

Route::prefix('services')->group(function () {
    Route::get('load','ServicesController@loadServiceFromApi')->name('load-services');
    Route::get('get','ServicesController@getServices')->name('get-service-list');
    Route::post('get-service-options','ServicesController@getServiceOption')->name('get-service-options');
    Route::get('get-service-name','ServicesController@getServiceNameList')->name('get-name');
});


Route::prefix('order')->group(function () {
    Route::post('add','OrdersController@add')->name('get-new-order');
    Route::get('add-order','OrdersController@addOrder')->name('get-order');
    Route::post('status','OrdersController@status')->name('get-status');
    Route::post('history','OrdersController@history')->name('get-history');
});

Route::prefix('user')->group(function () {
    Route::get('balance','UserController@balance')->name('get-balance');
});
