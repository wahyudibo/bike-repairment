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
    Route::get('/', 'WorkUnitController@get');
    Route::put('/', 'WorkUnitController@update');
    Route::delete('/', 'WorkUnitController@destroy');
});
