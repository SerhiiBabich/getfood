<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Redirect;

class SetLocaleController extends Controller
{
    // Set language of application
    public function setLocale(Request $request) : RedirectResponse
    {
        $lang = $request->lang; // route parameters 'setlocale/{lang}'

        $referer = Redirect::back()->getTargetUrl(); // Previous page URL
        $parse_url = parse_url($referer, PHP_URL_PATH); // URI previous page

        // we divide into an array on a separator
        $segments = explode('/', $parse_url);

        // if the URL (where the language switch was clicked) contained the correct language label
        if (in_array($segments[1], Locale::$languages))  unset($segments[1]) ; // remove tag

        // Add a language label to the URL (if you choose a non-default language)
        if ($lang != Locale::$mainLanguage) array_splice($segments, 1, 0, $lang);
        
        // we form full URL
        $url = $request->root().implode("/", $segments);

        // if there were still GET parameters - add them
        if(parse_url($referer, PHP_URL_QUERY)){
            $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
        }
        return redirect($url); // Redirect back to the same page.
    }
}
