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
    Route::get('/edit/email', 'Email\EditEmailController@index')->name('edit.email');
    Route::post('/edit/email', 'Email\EditEmailController@edit')->name('edit.email');
});

// confirmation email
Route::get('/email/confirmation/{token}', 'Email\ConfirmationEmailController@confirm')->name('email.confirmation')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
