<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/repairment', 'RepairmentController@store');

Route::prefix('work-units')->group(function () {
    Route::get('/{workUnit}', 'WorkUnitController@get');
    Route::get('/', 'WorkUnitController@datatable');
    Route::post('/', 'WorkUnitController@store');
    Route::put('/{workUnit}', 'WorkUnitController@update');
    Route::delete('/{workUnit}', 'WorkUnitController@destroy');
});

Route::prefix('bike-types')->group(function () {
    Route::get('/{bikeType}', 'BikeTypeController@get');
    Route::get('/', 'BikeTypeController@datatable');
    Route::post('/', 'BikeTypeController@store');
    Route::put('/{bikeType}', 'BikeTypeController@update');
    Route::delete('/{bikeType}', 'BikeTypeController@destroy');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'DashboardController@datatable');
    Route::get('/stats', 'DashboardController@showStats');
    Route::get('/{reportId}', 'DashboardController@show');
    Route::put('/{reportId}', 'DashboardController@updateReportStatus');
});
