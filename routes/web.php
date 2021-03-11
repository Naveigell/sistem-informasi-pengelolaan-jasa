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
Route::view("/technician", "technician.index");
Route::get("/technician/{username}", function ($username) {
    return view("technician.update", compact("username"));
});

Route::view("/user", "user.index");

Route::group(['prefix' => '/account'], function () {
    Route::view('/biodata', 'user.account.biodata');
});

// v1 api versioning
Route::group(['prefix' => '/api/v1'], function () {
    // lot of routes had been moved into separated functions on app\Http\Providers\RouteServiceProvider
    // AUTH ROUTES moved into app\Http\Providers\RouteServiceProvider
    // BIODATA ROUTES moved into app\Http\Providers\RouteServiceProvider
    // SPAREPART ROUTES moved into app\Http\Providers\RouteServiceProvider
    // TECHNICIAN ROUTES moved into app\Http\Providers\RouteServiceProvider
    // JASA ROUTES moved into app\Http\Providers\RouteServiceProvider
    Route::group(["prefix" => "/users", "middleware" => "auth.global"], function () {
//        Route::get("/search", "Api\Technician\TechnicianController@search");
//        Route::get("/{page?}", "Api\Technician\TechnicianController@retrieveAll");
//        Route::get("/username/{username}", "Api\Technician\TechnicianController@retrieveByUsername");
//        Route::post("/", "Api\Technician\TechnicianController@create");
//        Route::delete("/{id}", "Api\Technician\TechnicianController@delete");
//        Route::put("/", "Api\Technician\TechnicianController@update");
//        Route::post("/reset-password", "Api\Technician\TechnicianController@resetPassword");
        Route::get("/search", "Api\User\UserController@search");
        Route::get("/{page?}", "Api\User\UserController@retrieveAll");
        Route::post("/", "Api\User\UserController@create");
    });
});
