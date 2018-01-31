<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Locale
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
        if (Auth::check()) {
            //echo "<script>alert('".Auth::user()->lang."')</script>";
            App::setlocale(Auth::user()->lang);
            Session::put('secondary_lang', Auth::user()->secondary_lang);
        }else if(!Session::has('insta_language_change_used')){
 
            $languages = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']) : [];
            foreach($languages as $language)
            {
                $language = explode('-',$language)[0];
                if(in_array($language, config('constants.supported_languages.array'))){
                    // Set the page locale to the first supported language found
                    App::setlocale($language);
                    $lang=$language;
                    break;
                }
            }
            foreach($languages as $secondary_language)
            {
                $secondary_language = explode('-',$secondary_language)[0];
                if(in_array($secondary_language, config('constants.supported_languages.array')) && $secondary_language != $lang){
                    // Set the page locale to the second supported language found
                    Session::put('secondary_lang', $secondary_language);
                    break;
                }
            }
            Session::put('secondary_lang', 'en');
        }else{
            App::setlocale(Session::get('insta_language_change_used'));
        }


        return $next($request);
    }
}
