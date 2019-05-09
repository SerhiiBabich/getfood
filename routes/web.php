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

// Route to set the language
Route::get('setlocale/{lang}', 'Business\Location\SetLocale@setLocale')->name('setlocale');

// The route for the main page without installing language
Route::get('/', function () {
    return redirect('/'. config('app.locale'));
});

/*
|------------------------------
| Routes with localization
|------------------------------
*/
Route::group(['prefix' => \App\Http\Controllers\Business\Location\GetLocale::getLocale()], function (){

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/home/', 'HomeController@index')->name('home');
});

