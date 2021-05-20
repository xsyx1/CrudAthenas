<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return response()->json(['app' => 'Cerrado Dourado', 'version' => '1.0.0']);
});


Route::group(['prefix' => 'v1', 'namespace' => 'API'], function () {

    Route::middleware(['app'])->group(function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'SessionController@store');
            Route::post('resetpassword', 'ResetPasswordController@store');
            Route::post('users', 'UserController@store');

            Route::middleware('auth:api')->group(function () {
                Route::delete('logout', 'SessionController@destroy');
            });
        });

    });



    Route::apiResource('states', 'StateController')->only(['index', 'show']);
    Route::apiResource('cities', 'CityController')->only(['index', 'show']);

});
