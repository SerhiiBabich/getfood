<?php
declare(strict_types=1);

namespace App\Http\Controllers\Business\Location;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Redirect;

class SetLocale
{
    // Set language of application
    public function setLocale(Request $request) : RedirectResponse
    {
        $url = $this->getURLIsGet($request);
        
        return redirect($url); // Redirect back to the same page.
    }

    /** Generates the full URL if there were GET parameters will add them
     *
     * @param Request $request
     * @return string
     */
    private function getURLIsGet(Request $request) : string
    {
        $referer = $this->getReferer();

        // form full URL
        $url = $request->root().implode("/", $this->addLanguageLabelURL($request->lang)); // $request->lang - route parameters 'setlocale/{lang}'

        // if there were still GET parameters - add them
        if(parse_url($referer, PHP_URL_QUERY)){
            $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
        }
        return $url;
    }

    /**Previous page URL
     *
     * @return string
     */
    private function getReferer() : string
    {
        return Redirect::back()->getTargetUrl();
    }

    private function addLanguageLabelURL($lang) : array
    {
        $segments = $this->getSegmentsURL();

        // clear the language label in the URL (where the language switch was selected) if it contained the correct language label or is empty
        if (empty($segments[1]) || in_array($segments[1], config('app.locales')))  unset($segments[1]) ; // remove tag

        // Add a language label to the URL (if you want to show the main language)
        if(config('app.language_url')) $segments[1] = $lang;

        // Add a language label to the URL (if you choose a non-default language)
        elseif($lang != config('app.locale')) $segments[1] = $lang;

        return $segments;
    }

    private function getSegmentsURL() : array
    {
        $parse_url = parse_url($this->getReferer(), PHP_URL_PATH); // URI previous page

        // we divide into an array on a separator
        $segments = explode('/', $parse_url);

        return $segments;
    }


}
