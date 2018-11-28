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
Route::get('/test', 'DashboardController@test');

Route::get('/', 'HabitController@getDaily');

/* Log data to FitBit */
Route::post('/dashboard/exercise/log', 'HabitController@logActivity');
Route::post('/dashboard/exercise/changegoal', 'HabitController@changeActivityGoal');

/* Fitbit Authentication */
Route::get('login/fitbit', 'UserController@redirectToFitbit');
Route::get('login/fitbit/callback', 'UserController@handleFitbitCallback');
Route::post('/logout', 'UserController@logout');
Route::post('/delete', 'UserController@delete');

/* API calls */
Route::get('/profile', 'UserController@showProfile');
Route::get('/dashboard', 'DashboardController@index');
Route::post('/dashboard', 'DashboardController@storeFeedback');
Route::post('/api/addwater', 'DashboardController@AddWater');
Route::post('/api/watergoal', 'DashboardController@WaterGoal');

/* Inter API calls */
Route::get('/api/getstats', 'UserController@getStats');
Route::get('/api/getweeksleep', 'UserController@getWeekSleepStats');
Route::get('/api/getdaysleep', 'UserController@getDaySleepStats');
Route::get('/api/getweekactivity', 'UserController@getWeekActivityStats');
Route::get('/api/getdayactivity', 'UserController@getDayActivityStats');
Route::get('/api/getdaybreathing', 'UserController@getDayBreathingStats');
Route::get('/api/getdaywater', 'UserController@getDayWaterStats');

/* Habits */
Route::get('/dashboard/{habit}/session', 'HabitController@showbreath');
Route::post('/dashboard/{habit}/session', 'HabitController@trackbreath');
Route::get('/dashboard/{habit}', 'HabitController@show');
Route::post('/dashboard/{habit}', 'HabitController@track');

/* Admin page */
Route::get('/admin', 'AdminController@index')->middleware('auth', 'admin');