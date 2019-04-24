<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Lang;


class Locale
{
    private static $mainLanguage = 'ru'; // основной язык, который не должен отображаться в URl
    private static $languages = ['en', 'ru', 'uk']; // языки которые будут использоватся в приложении.

//    private function __construct()
//    {
//        self::$mainLanguage = Lang::locale();  # устанавливаем основной язык, который не должен отображаться в URl
//    }

    /**
     * Проверяем наличие корректной метки языка
     * Возвращает метку или значеие null, если нет метки
     *
     */
    public static function getLocale()
    {
        return 'ru';

    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $raw_locale = Session::get('locale');     # Если пользователь уже был на нашем сайте,
//        # то в сессии будет значение выбранного им языка.
//
//        if (in_array($raw_locale, Config::get('app.locales'))) {  # Проверяем, что у пользователя в сессии установлен доступный язык
//            $locale = $raw_locale;                                # (а не какая-нибудь бяка)
//        }                                                         # И присваиваем значение переменной $locale.
//        else $locale = Config::get('app.locale');                 # В ином случае присваиваем ей язык по умолчанию
//
//        App::setLocale($locale);                                  # Устанавливаем локаль приложения
//
        $locale = self::getLocale();

        if($locale) App::setLocale($locale);
        //если метки нет - устанавливаем основной язык $mainLanguage
        else App::setLocale(self::$mainLanguage);

        return $next($request);                                   # И позволяем приложению работать дальше
    }  
}
