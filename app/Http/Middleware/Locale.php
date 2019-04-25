<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Session;
use Request;
use Lang;


class Locale
{
    public static $mainLanguage = 'ru'; // основной язык, который не должен отображаться в URI
    public static $languages = ['en', 'ru']; // языки которые будут использоватся в приложении.


    /**
     * Проверяем наличие корректной метки языка
     * Возвращает метку или значеие null, если нет метки
     *
     */
    public static function getLocale()
    {
        /** Если пользователь уже был на нашем сайте,
         *  то в сессии будет значение выбранного им языка.
         */
//        $raw_locale = Session::get('locale');
//        // Проверяем, что у пользователя в сессии установлен доступный язык
//        if (!empty($raw_locale) && in_array($raw_locale, self::$languages)) {
//
//            //            if ($raw_locale != self::$mainLanguage) return $raw_locale; // Если нужно чтобы осн. язык не отображался в URL добавить эту проверку
//            return $raw_locale;
//        }else{
//            return self::$mainLanguage;
//        }


        $uri = Request::path(); // получаем URI

        $segmentsURI = explode('/',$uri); // делим на части по разделителю "/"

        //Проверяем метку языка  - есть ли она среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::$languages))
        {
//            if ($segmentsURI[0] != self::$mainLanguage) return $segmentsURI[0];; // Если нужно чтобы осн. язык не отображался в URL добавить эту проверку
            return $segmentsURI[0]; //Если нужно чтобы осн. язык отображался
        }else{
//            return null; //Если нужно чтобы осн. язык не отображался в URI
            return self::$mainLanguage; //Если нужно чтобы осн. язык отображался в URI
        }

    }
    
    /** Устанавливает язык приложения в зависимости от метки языка из URI
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $locale = self::getLocale();

        if($locale) App::setLocale($locale);
        //если метки нет - устанавливаем основной язык $mainLanguage
        else App::setLocale(self::$mainLanguage);

        return $next($request);
    }  
}
