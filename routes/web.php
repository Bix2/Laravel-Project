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

/* Fitbit Authentication */
Route::get('login/fitbit', 'FitbitAuthController@redirectToFitbit');
Route::get('login/fitbit/callback', 'FitbitAuthController@handleFitbitCallback');
Route::get('/logout', 'Auth\LoginController@logout');

/* API calls */
// Route::get('/profile', 'FitbitAuthController@showProfile');
Route::get('/dashboard', 'DashboardController@checkIfHabitsAreTracked');
Route::get('/profile', 'FitbitApiController@index'); // om je te laten zien dat die brulath library dus ook werkt, en die hebben allemaakl api calls al

/* Habits */
Route::get('/dashboard/{habit}', 'HabitController@show');
Route::post('/dashboard/{habit}', 'HabitController@trackHabit');