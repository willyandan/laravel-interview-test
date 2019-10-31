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

// TODO @laravel-test
Route::prefix('calculator')->middleware('auth:api')->group(function(){
    Route::get('add', '\App\Http\Controllers\CalculatorController@add');
    Route::get('sub', '\App\Http\Controllers\CalculatorController@sub');
    Route::get('div', '\App\Http\Controllers\CalculatorController@div');
    Route::middleware('user.premium')->group(function(){
        Route::get('mod', '\App\Http\Controllers\CalculatorController@mod');
    });
    Route::get('mul', '\App\Http\Controllers\CalculatorController@mul');
});
