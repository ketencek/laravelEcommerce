<?php


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (! function_exists('str_between')) {
    /**
     * Get the portion of a string between the given values.
     *
     * @param string $subject
     * @param string $search
     * @return string
     */
    function str_between($subject, $startsWith, $endsWith)
    {
        return str_after(str_before($subject, $endsWith), $startsWith);
    }
}

if (! function_exists('locale')) {
    /**
     * Get current locale.
     *
     * @return string
     */
    function locale()
    {
        return app()->getLocale();
    }
}

if (! function_exists('supported_locales')) {
    /**
     * Get all supported locales.
     *
     * @return array
     */
    function supported_locales()
    {
        return LaravelLocalization::getSupportedLocales();
    }
}

if (! function_exists('supported_locale_keys')) {
    /**
     * Get all supported locale keys.
     *
     * @return array
     */
    function supported_locale_keys()
    {
        return LaravelLocalization::getSupportedLanguagesKeys();
    }
}

if (! function_exists('localized_url')) {
    /**
     * Returns an URL adapted to the given locale.
     *
     * @param string $locale
     * @param string $url
     * @return string
     */
    function localized_url($locale, $url = null)
    {
        return LaravelLocalization::getLocalizedURL($locale, $url);
    }
}

if (! function_exists('non_localized_url')) {
    /**
     * It returns an URL without locale.
     *
     * @param string $url
     * @return string
     */
    function non_localized_url($url = null)
    {
        return LaravelLocalization::getNonLocalizedURL($url);
    }
}

if (! function_exists('is_multilingual')) {
    /**
     * Determine if the app has multi language.
     *
     * @return bool
     */
    function is_multilingual()
    {
        return count(supported_locales()) > 1;
    }
}


if (! function_exists('slugify')) {
    /**
     * Generate a URL friendly "slug" from a given string
     *
     * @param string $value
     */
    function slugify($value)
    {
        $slug = preg_replace('/[\s<>[\]{}|\\^%&\$,\/:;=?@#\'\"]/', '-', mb_strtolower($value));

        // Remove duplicate separators.
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim special characters from the beginning and end of the slug.
        return trim($slug, '!"#$%&\'()*+,-./:;<=>?@[]^_`{|}~');
    }
}

if (! function_exists('getSubString')) {
    function getSubString($string, $char)
    {
        $m_string = strip_tags(html_entity_decode($string));

        if (strlen($m_string) > $char) {
            $new_string = substr($m_string, 0, $char);

            $new_length = strrpos($new_string, " ");

            $m_new_string = substr($new_string, 0, $new_length) . "...";

            return $m_new_string;
        } else {
            return $m_string;
        }
    }

}

if(! function_exists('getcontent')) {
    function getcontent($string)
    {
        $new_string = stripcslashes(html_entity_decode($string));
        return $new_string;
    }
}