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
/*
|---------------------------
| Маршруты с локалищацией
|---------------------------
 */
Route::group(['prefix' => \App\Http\Middleware\Locale::getLocale()], function (){

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/home/', 'HomeController@index', function ()
    {
    })->name('home');
});

//
//Route::get('/setlocale/{locale}', function ($locale) {
//
//    if (in_array($locale, \Config::get('app.locales'))) {   # Проверяем, что у пользователя выбран доступный язык
//        Session::put('locale', $locale);                    # И устанавливаем его в сессии под именем locale
//    }
//
//    return redirect()->back();                              # Редиректим его <s>взад</s> на ту же страницу
//
//});
