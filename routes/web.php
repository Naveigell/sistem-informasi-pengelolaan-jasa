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

Route::group(['prefix' => '/account'], function () {
    Route::view('/biodata', 'user.account.biodata');
});

Route::get("/test", function (){
    var_dump(auth("user")->user()->user);
});

// v1 api versioning
Route::group(['prefix' => '/api/v1'], function () {
    // auth
    Route::post('/auth/login', 'Api\Auth\LoginController@login');
    Route::get('/auth/check', 'Api\Auth\AuthController@check');
    Route::get('/auth/session/data', 'Api\Auth\AuthController@sessionData');

    Route::middleware("auth.global")->group(function () {
        Route::prefix("/biodata")->group(function (){
            Route::get('/', 'Api\User\Account\BiodataController@retrieveBiodata');
            Route::put('/', 'Api\User\Account\BiodataController@updateBiodata');
            Route::post('/image', 'Api\User\Account\BiodataController@updateProfilePicture');
        });

        Route::prefix("/spareparts")->group(function (){
            Route::get("/search", "Api\Sparepart\SparepartController@search");
            Route::get("/{page?}", "Api\Sparepart\SparepartController@retrieveAll")->name('sparepart.index');
        });
    });

});
