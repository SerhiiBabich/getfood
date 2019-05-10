<?php
declare(strict_types=1);

namespace App\Http\Controllers\Business\Location;

use Request;

class GetLocale
{
    /** Main language in application
     *
     * @return string
     */
    private static function getMainLanguage() : string
    {
        return (string) config('app.locale');
    }

    /** Languages that are used in the application.
     *
     * @return array
     */
    private static function getLanguages() : array 
    {
        return config('app.locales');
    }

    private static function localeSegmentsUri() : string
    {
        $uri = Request::path(); // get URI

        $segmentsURI = explode('/',$uri); // divide by parts by separator "/"
        
        return $segmentsURI[0];
    }

    /** Show main application language in URL
     *
     * @return bool
     */
    private static function showLanguageURL() : bool
    {
        return (bool) config('app.language_url');
    }

    /**
     * Check for the presence of the correct language label
     * Returns a label or a null value if there is no label
     *
     * @return string
     */
    public static function getLocale() : string
    {
        $mainLanguage = self::getMainLanguage();
        $segmentsURI = self::localeSegmentsUri();

        // Check the language label - is it among the available languages
        if (!empty($segmentsURI) && in_array($segmentsURI, self::getLanguages()))
        {
            if(self::showLanguageURL()) return $segmentsURI;
            if($segmentsURI != $mainLanguage) return $segmentsURI ;
        }else{
            if(self::showLanguageURL()) return $mainLanguage;
        }
        return '';
    }

}
