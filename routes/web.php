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

Route::get('/login', function() {
    return view('login');
});

Route::get('/user', function() {
    return view('user');
});

Route::get('/dashboard', function() {
    return view('dashboard');
});
/*Route::get('/project/{slug}', function($slug) {
    return response()->json(\App\Project::where('slug', '=', $slug)->first());
});*/
