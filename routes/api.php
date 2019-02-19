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

Route::namespace('Api')->group(function () {
    Route::get('/access-tokens/page', 'AccessTokensController@index')->name('access_token.index');
    Route::post('/scancodes', 'ScanCodesController@store')->name('scancode.store');
});
