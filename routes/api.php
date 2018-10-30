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
    Route::get('load', 'ServicesController@loadServiceFromApi')->name('load-services');
    Route::post('get', 'ServicesController@getServices')->name('get-services');
    Route::post('get-service-options', 'ServicesController@getServiceOption')->name('get-service-options');
});

Route::prefix('order')->group(function () {
    Route::post('prepare', 'OrdersController@prepare')->name('order-prepare');
    Route::post('add', 'OrdersController@add')->name('get-new-order');
    Route::post('status', 'OrdersController@status')->name('get-status');
    Route::post('history', 'OrdersController@history')->name('get-history');
});

Route::prefix('category')->group(function () {
    Route::post('get', 'CategoryController@getCategories')->name('get-categories');
});

Route::prefix('platform')->group(function () {
    Route::get('get', 'PlatformController@getPlatform')->name('get-platform');
});

Route::prefix('user')->group(function () {
    Route::get('balance', 'UserController@balance')->name('get-balance');
});
