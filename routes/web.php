<?php

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
    return view('welcome');
});

Route::get('/user', 'UserController@index');

Route::get('/dashboard', 'DashboardController@index');

Route::get('login/fitbit', 'FitbitController@redirectToFitbit');
Route::get('login/fitbit/callback', 'FitbitController@handleUserInfo');

Route::get('/logout', function() {
    Auth::logout();
});


