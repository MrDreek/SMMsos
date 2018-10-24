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

Route::get('get-data','Api@getData')->name('get-data');

Route::prefix('services')->group(function () {
    Route::post('get','ServicesController@getServices')->name('get-service-list');
});

Route::prefix('categories')->group(function () {
    Route::get('get','CategoriesController@getCategories')->name('get-category-list');
});

Route::prefix('order')->group(function () {
    Route::post('add','OrdersController@add')->name('get-new-order');
    Route::post('status','OrdersController@status')->name('get-status');
});

Route::prefix('user')->group(function () {
    Route::get('balance','UserController@balance')->name('get-balance');
});
