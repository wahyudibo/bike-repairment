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
    return view('front.index');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/report', 'ReportController@index')->name('report');
    Route::get('/work-unit', 'WorkUnitController@index')->name('work-unit');
    Route::get('/bike-type', 'BikeTypeController@index')->name('bike-type');

});
