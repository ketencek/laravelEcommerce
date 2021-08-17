<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      \App::setLocale(config('settingconfig.admin_default_language'));
        // /*if(\Session::has('locale'))
        // {
        //   \App::setlocale(\Session::get('locale'));
        // }*/
        // //Check for 'lang' cookie
        // $cookie = \Cookie::get('lang');
        // //Get visitors IP
        // $userIp = \Request::ip();
        // //Get visitors Geo info based on his IP
        // $geo = \GeoIP::getLocation($userIp);
        // // echo "<pre>";
        // // print_r($geo);
        // // exit;

        // if($geo == null) {
        //     //Probably a localhost server, set language to english
        //     //set locale from cookie if exists
        //     if (!isset($cookie) && !empty($cookie)) {
        //         \App::setLocale($cookie);
        //         return;
        //     }
        //     \App::setLocale('en');
        // }else{
        //   // //Get visitors country name
        //   $userCountry = $geo['country'];
        //   //Set language based on country name
        //   // You can add as many as you want
        //   $supportedLanguages = [
        //       'Spain' => 'es',
        //       'Germany' => 'de',
        //       'France' => 'fr',
        //   ];

        //   if (!empty($cookie)) {
        //       //User has manually chosen a lang. We set it
        //       \App::setLocale($cookie);
        //   } else {
        //       //Check country name in supportedLanguages array
        //       if (array_key_exists($userCountry, $supportedLanguages)) {
        //           //Get userCountry value(language) from array
        //           $preferredLang = $supportedLanguages[$userCountry];
        //           //Set language based on value
        //           \App::setLocale($preferredLang);
        //       } else {
        //           //If user is visiting from an unsupported country, default to English
        //           \App::setLocale('en');
        //       }
        //   }
        // }

      return $next($request);
    }
}