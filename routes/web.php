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

Route::get('/', function () {
    return view('index');
});

// v1 api versioning
Route::group(['prefix' => '/api/v1'], function () {
    // auth
    Route::post('/auth/login', 'Api\Auth\LoginController@login');
    Route::get('/auth/check', 'Api\Auth\AuthController@check');
});
