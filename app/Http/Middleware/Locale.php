<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App;
use Closure;
use Request;

class Locale
{
    public static $mainLanguage = 'ru'; // main language that should not be displayed in a URI
    public static $languages = ['en', 'ru']; // languages to be used in the application.
    private static $displayLanguageURI = true;   // display the main language in the application
    
    /**
     * Check for the presence of the correct language label
     * Returns a label or a null value if there is no label
     *
     */
    public static function getLocale() : string
    {
        $uri = Request::path(); // get URI

        $segmentsURI = explode('/',$uri); // divide by parts by separator "/"

        // Check the language label - is it among the available languages
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::$languages))
        {
            if(self::$displayLanguageURI) return $segmentsURI[0];
            if($segmentsURI[0] != self::$mainLanguage) return $segmentsURI[0] ;
            return '';
        }else{
            $language = self::$displayLanguageURI ? self::$mainLanguage: '';
            return $language;
        }
    }
    
    /** Sets the application language depending on the language label from the URI
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
        //if there are no tags, set the main language $mainLanguage
        else App::setLocale(self::$mainLanguage);

        return $next($request);
    }  
}
