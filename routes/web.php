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

Auth::routes();

Route::group(['prefix'=> '/profile', 'middleware'=> 'auth'], function ()
{
    Route::get('/edit/email', 'Email\EditEmailController@index');
    Route::post('/edit/email', 'Email\EditEmailController@edit');
});

Route::get('/home', 'HomeController@index')->name('home');
