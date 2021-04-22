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
        Route::get("/retrieve/{id}", "Api\Suggestion\SuggestionController@retrieveSingle");
        Route::post("/", "Api\Suggestion\SuggestionController@store");
        Route::delete("/", "Api\Suggestion\SuggestionController@deleteMultipleSuggestions");
        Route::put("/{id}/reply", "Api\Suggestion\SuggestionController@replySuggestion");
    });

    Route::group(["prefix" => "/dashboard", "middleware" => "auth.global"], function () {
        Route::get("/total", "Api\Dashboard\DashboardController@total");
        Route::get("/graph", "Api\Dashboard\GraphController@retrieveData");
    });

    Route::group(["prefix" => "/complaints", "middleware" => "auth.global"], function () {
        Route::get("/", "Api\Complaint\ComplaintController@retrieveAll");
        Route::get("/retrieve/{id}", "Api\Complaint\ComplaintController@retrieve");
        Route::put("/do-complaint/{id}", "Api\Complaint\ComplaintController@doComplaint");
        Route::put("/do-accept/{id}", "Api\Complaint\ComplaintController@doAccept");
    });

    Route::group(["prefix" => "/orders", "middleware" => "auth.global"], function () {
        Route::get("/take/{number}/last", "Api\Order\OrderController@takeFromLast");
        Route::get("/total", "Api\Order\OrderController@getTotalOrders");
        Route::get("/search", "Api\Order\OrderController@search");
        Route::get("/search/spareparts", "Api\Order\OrderController@searchSparepart");
        Route::post("/search/spareparts", "Api\Order\OrderController@saveSparepart");
        Route::post("/complaint", "Api\Complaint\ComplaintController@saveComplaint");
        Route::get("/{page?}", "Api\Order\OrderController@retrieveAll");
        Route::get("/retrieve/{id}", "Api\Order\OrderController@retrieve");
        Route::post("/", "Api\Order\OrderController@create");
        Route::post("/take", "Api\Order\OrderController@take");
        Route::put("/status", "Api\Order\OrderController@updateStatusService");
        Route::delete("/{id}", "Api\Order\OrderController@delete");
    });

    Route::get("/reports/finance/excel", "Api\Reports\FinanceController@excelConverter");
});

Route::view('/{any}', "index")->where('any', '^(?!api).*');
