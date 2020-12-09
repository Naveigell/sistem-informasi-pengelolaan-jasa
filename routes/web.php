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

Route::group(['prefix' => '/account'], function () {
    Route::view('/biodata', 'user.account.biodata');
});

// v1 api versioning
Route::group(['prefix' => '/api/v1'], function () {

    // lot of routes had been moved into separated functions on app\Http\Providers\RouteServiceProvider
    // AUTH ROUTES moved into app\Http\Providers\RouteServiceProvider
    // BIODATA ROUTES moved into app\Http\Providers\RouteServiceProvider

    Route::middleware("auth.global")->group(function () {
        Route::prefix("/spareparts")->group(function (){
            Route::get("/search", "Api\Sparepart\SparepartController@search");
            Route::get("/retrieve/{id}", "Api\Sparepart\SparepartController@retrieve");
            Route::get("/{page?}", "Api\Sparepart\SparepartController@retrieveAll")->name('sparepart.index');
            Route::post("/", "Api\Sparepart\SparepartController@insert");
            Route::put("/", "Api\Sparepart\SparepartController@update");
        });
    });

});
