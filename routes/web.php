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
// views
Route::view("/", "index");
Route::view("/sparepart", 'sparepart.index');
Route::view("/sparepart/new", "sparepart.insert");
Route::get("/sparepart/{id}", "Views\SparepartController@edit");

Route::view("/service", "service.index");

Route::group(['prefix' => '/account'], function () {
    Route::view('/biodata', 'user.account.biodata');
});

// v1 api versioning
Route::group(['prefix' => '/api/v1'], function () {

    // lot of routes had been moved into separated functions on app\Http\Providers\RouteServiceProvider
    // AUTH ROUTES moved into app\Http\Providers\RouteServiceProvider
    // BIODATA ROUTES moved into app\Http\Providers\RouteServiceProvider
    // SPAREPART ROUTES moved into app\Http\Providers\RouteServiceProvider
    Route::group(["prefix" => "/service", "middleware" => "auth.global"], function () {
        Route::get("/", "Api\Jasa\JasaController@retrieveAll");
        Route::post("/", "Api\Jasa\JasaController@insert");
        Route::patch("/activate", "Api\Jasa\JasaController@activate");
        Route::put("/", "Api\Jasa\JasaController@update");
        Route::delete("/{id}", "Api\Jasa\JasaController@delete");
    });
});
