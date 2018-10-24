<?php


use Carbon\Carbon;
use App\Jobs\ProcessPodcast;

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

/* Fitbit Authentication */
Route::get('login/fitbit', 'UserController@redirectToFitbit');
Route::get('login/fitbit/callback', 'UserController@handleFitbitCallback');
Route::get('/logout', 'Auth\LoginController@logout');

/* API calls */
Route::get('/profile', 'UserController@showProfile');
Route::get('/dashboard', 'DashboardController@index');
Route::post('/dashboard', 'DashboardController@storeFeedback');

/* Habits */
Route::get('/dashboard/{habit}', 'HabitController@show');
Route::post('/dashboard/{habit}', 'HabitController@track');

/* Chrome Extension */
Route::get('/api/getstats', 'UserController@getStats');

/* Admin page */
Route::get('/admin', 'AdminController@index')->middleware('auth', 'admin');

Route::get('dosomething', 'DashboardController@doSomething');