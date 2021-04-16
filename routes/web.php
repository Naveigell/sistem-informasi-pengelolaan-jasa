<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// v1 api versioning
Route::group(['prefix' => '/api/v1'], function () {
    // lot of routes had been moved into separated functions on app\Http\Providers\RouteServiceProvider
    Route::group(["prefix" => "/users", "middleware" => "auth.global"], function () {
        Route::get("/search/email", "Api\User\UserController@searchEmail");
        Route::get("/search", "Api\User\UserController@search");
        Route::get("/{page?}", "Api\User\UserController@retrieveAll");
        Route::post("/", "Api\User\UserController@create");
        Route::delete("/{id}", "Api\User\UserController@delete");
    });

    Route::group(["prefix" => "/suggestions", "middleware" => "auth.global"], function () {
        Route::get("/{last_id}", "Api\Suggestion\SuggestionController@retrieveAll");
        Route::post("/", "Api\Suggestion\SuggestionController@store");
        Route::get("/retrieve/{id}", "Api\Suggestion\SuggestionController@retrieveSingle");
    });

    Route::group(["prefix" => "/dashboard", "middleware" => "auth.global"], function () {
        Route::get("/total", "Api\Dashboard\DashboardController@total");
    });

    Route::group(["prefix" => "/orders", "middleware" => "auth.global"], function () {
        Route::get("/take/{number}/last", "Api\Order\OrderController@takeFromLast");
        Route::get("/total", "Api\Order\OrderController@getTotalOrders");
        Route::get("/search", "Api\Order\OrderController@search");
        Route::get("/search/spareparts", "Api\Order\OrderController@searchSparepart");
        Route::post("/search/spareparts", "Api\Order\OrderController@saveSparepart");
        Route::get("/{page?}", "Api\Order\OrderController@retrieveAll");
        Route::get("/retrieve/{id}", "Api\Order\OrderController@retrieve");
        Route::post("/", "Api\Order\OrderController@create");
        Route::post("/take", "Api\Order\OrderController@take");
        Route::put("/status", "Api\Order\OrderController@updateStatusService");
        Route::delete("/{id}", "Api\Order\OrderController@delete");
    });
});

Route::view('/{any}', "index")->where('any', '^(?!api).*');
