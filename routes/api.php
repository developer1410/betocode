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

Route::post('login', 'Authorization\LoginController@login');

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::post('logout', 'Authorization\LoginController@logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('organisation')->namespace('Organisation')->group(function () {
        Route::get('', 'OrganisationController@index');
        Route::post('', 'OrganisationController@store');
    });
});
