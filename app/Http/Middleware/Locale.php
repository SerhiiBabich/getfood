<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App;
use Closure;
use App\Http\Controllers\Business\Location\GetLocale;

class Locale
{
    /** Sets the application language depending on the language label from the URI
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = GetLocale::getLocale();

        if($locale) App::setLocale($locale);
        //if there are no tags, set the main language $mainLanguage
        else App::setLocale(config('app.locale'));

        return $next($request);
    }  
}
