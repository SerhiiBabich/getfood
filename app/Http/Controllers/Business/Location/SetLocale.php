<?php
declare(strict_types=1);

namespace App\Http\Controllers\Business\Location;

//use App\Http\Controllers\Controller;
use App\Http\Middleware\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Redirect;

class SetLocale
{
    // Set language of application
    public function setLocale(Request $request) : RedirectResponse
    {
        $lang = $request->lang; // route parameters 'setlocale/{lang}'
//        $referer = Redirect::back()->getTargetUrl(); // Previous page URL
        $referer = $this->getReferer();
        $parse_url = parse_url($referer, PHP_URL_PATH); // URI previous page

        // we divide into an array on a separator
        $segments = explode('/', $parse_url);

        // if the URL (where the language switch was clicked) contained the correct language label
        if (empty($segments[1]) || in_array($segments[1], config('app.locales')))  unset($segments[1]) ; // remove tag
        if(config('app.language_url'))
        {
            array_splice($segments, 1, 0, $lang);
        }elseif($lang != config('app.locale')){
            // Add a language label to the URL (if you choose a non-default language)
            array_splice($segments, 1, 0, $lang);
        }
        
        
        // we form full URL
        $url = $request->root().implode("/", $segments);;
        // if there were still GET parameters - add them
        if(parse_url($referer, PHP_URL_QUERY)){
            $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
        }
        return redirect($url); // Redirect back to the same page.
    }

    /**Previous page URL
     * 
     * @return string
     */
    private function getReferer() : string
    {
        return Redirect::back()->getTargetUrl();
    }
}
