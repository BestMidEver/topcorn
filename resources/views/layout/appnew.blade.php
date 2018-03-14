<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="MyApp" ng-controller="@yield('controllername')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @section('title')
        @show
    </title>

    <link rel="icon" type="image/png" href="/images/topcorn_logo.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angularjs-slider/6.4.0/rzslider.min.css"/>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/js/fallbackcdn/jquery-3.2.1.slim.min.js"><\/script>')</script>

    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <!--<script>window.FontAwesomeCdnConfig || document.write('<script src="/js/fallbackcdn/fontawesome.js"><\/script>')</script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script>typeof(Popper) == undefined || document.write('<script src="/js/fallbackcdn/popper.min.js"><\/script>')</script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>$.fn.modal || document.write('<script src="/js/fallbackcdn/bootstrap.min.js"><\/script>')</script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script>window.angular || document.write('<script src="/js/fallbackcdn/angular.min.js"><\/script>')</script>
    
    @yield('underscore')

    @yield('angular_sanitize')

    @yield('passdata')

    <script src="/js/app.js"></script>

    <script src="/js/functions/rate_by_index.js"></script>  

    @yield('angular_controller_js')
</head>




<body>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/{{ app()->getLocale() }}_{{ strtoupper(app()->getLocale()) }}/sdk.js#xfbml=1&version=v2.11';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>




    <nav class="navbar navbar-expand-md navbar-dark bg-night">
        <a class="navbar-brand ml-auto d-none d-md-inline" href="/">
            <img src="/images/topcorn_logo.png" width="50" height="50" alt="">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link d-md-none" href="/home"><i class="fa fa-home" aria-hidden="true"></i><span class="d-none d-md-inline"> {{ __('navbar.home') }}</span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto pr-3">
            <li class="nav-item">
                <a class="nav-link d-md-none text-warning" href="/register"><i class="fa fa-plus" aria-hidden="true"></i><span class=""> {{ __('navbar.register') }}</span></a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link d-md-none text-white" href="/login"><i class="fa fa-sign-in-alt" aria-hidden="true"></i><span class=""> {{ __('navbar.login') }}</span></a>
            </li>
        </ul>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="fa fa-home d-none d-md-inline" aria-hidden="true"></i> {{ __('navbar.home') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto d-none d-md-flex">
                <li class="nav-item">
                    <a class="nav-link text-warning" href="/register"><i class="fa fa-plus d-none d-md-inline" aria-hidden="true"></i> <span class="">{{ __('navbar.register') }}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/login"><i class="fa fa-sign-in-alt" aria-hidden="true"></i> <span class="">{{ __('navbar.login') }}</span></a>
                </li>
            </ul>
        </div>
    </nav>




    <div class="container-fluid px-1 px-md-3 px-lg-5">
        @section('body')
        @show
    </div>




    <footer class="footer">
        <div class="container pt-5">
            <div class="row text-center text-sm-left">
                <div class="col col-sm-3 d-none d-sm-inline">
                    <div class="py-2 small"><a class="text-dark" href="/faq">{{ __('navbar.faq') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="https://www.facebook.com/topcorn.io/" target="_blank">{{ __('navbar.contact_us') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/privacy-policy">{{ __('navbar.privacy') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/donation">{{ __('navbar.donation') }}</a></div>
                </div>
                <div class="col col-sm-3 d-none d-sm-inline">
                    <div class="py-2 small"><a class="text-dark" href="/login">{{ __('navbar.login') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/register">{{ __('navbar.register') }}</a></div>
                </div>
                <div class="col-4 col-sm-2">
                    <div class="py-2 small"><a class="text-dark" href="/change_insta_language/en">English</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/change_insta_language/tr">Türkçe</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/change_insta_language/hu">Magyar</a></div>
                </div>
                <div class="col-8 col-sm-4 text-sm-right">
                    <div class=" h-100 d-flex flex-column justify-content-between">
                        <div class="py-2 small">
                            <div class="text-dark pb-1">{{ __('navbar.like_us_on_facebook') }}</div>
                            <div class="fb-like mr-1 mb-2" data-href="https://www.facebook.com/topcorn.io/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
                            <div class="fb-share-button" data-href="https://topcorn.io/" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Ftopcorn.io%2F&amp;src=sdkpreparse"></a></div>
                        </div>
                        <div class="text-middle-light small py-2"><span>© 2018 {{ config('app.name') }}. {{ __('navbar.all_rights_reserved') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
