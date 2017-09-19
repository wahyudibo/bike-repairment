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
    $googleMapApiKey = env('GOOGLE_MAPS_API_KEY');

    return view('front', compact('googleMapApiKey'));
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/report', 'ReportController@index')->name('report');
    Route::get('/repairment/{repairmentId}/map', 'RepairmentController@showMap');

    Route::prefix('data')->group(function () {
        Route::get('/work-units', 'WorkUnitController@index')->name('workUnits.index');
        Route::get('/bike-types', 'BikeTypeController@index')->name('bikeTypes.index');
    });
});
