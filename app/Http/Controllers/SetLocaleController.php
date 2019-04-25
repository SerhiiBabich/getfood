<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Locale;
use Illuminate\Http\Request;
use Redirect;

class SetLocaleController extends Controller
{
    public function setLocale(Request $request)
    {
        $lang = $request->lang; //параметр с маршрута 'setlocale/{lang}'

        $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
        $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

        //разбиваем на массив по разделителю
        $segments = explode('/', $parse_url);

        //Если URL (где нажали на переключение языка) содержал корректную метку языка
        if (in_array($segments[1], Locale::$languages)) {

            unset($segments[1]); //удаляем метку
        }

        //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
        if ($lang != Locale::$mainLanguage){
            array_splice($segments, 1, 0, $lang);
        }

        //формируем полный URL
        $url = $request->root().implode("/", $segments);

        //если были еще GET-параметры - добавляем их
        if(parse_url($referer, PHP_URL_QUERY)){
            $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
        }
        return redirect($url); //Перенаправляем назад на ту же страницу
    }
}
