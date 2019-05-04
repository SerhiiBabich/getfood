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
// Маршрут для установки языка
Route::get('setlocale/{lang}', 'SetLocaleController@setLocale')->name('setlocale');
// Маршрут для главной страницы  без установки языка
Route::get('/', function () {
    return redirect('/'. App\Http\Middleware\Locale::$mainLanguage);
});

/*
|------------------------------
| Маршруты с локалищацией
|------------------------------
*/
Route::group(['prefix' => \App\Http\Middleware\Locale::getLocale()], function (){

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/home/', 'HomeController@index')->name('home');
});

