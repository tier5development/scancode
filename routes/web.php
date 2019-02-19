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

Route::get('/', 'PagesController@index')->name('index');
Route::get('/tier5', 'PagesController@tier5')->name('tier5');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('auth/facebook', 'Auth\LoginController@handleFacebookAuth')->name('facebook.auth');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback')->name('facebook.callback');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'PagesController@home')->middleware('auth')->name('home');
