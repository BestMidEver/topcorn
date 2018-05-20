<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="MyApp" ng-controller="@yield('controllername')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description')">

    @yield('og_tags')

    <title>
        @section('title')
        @show
    </title>

    <link rel="icon" type="image/png" href="/images/topcorn_logo.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/style.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/js/fallbackcdn/jquery-3.2.1.slim.min.js"><\/script>')</script>

    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <!--<script>window.FontAwesomeCdnConfig || document.write('<script src="/js/fallbackcdn/fontawesome.js"><\/script>')</script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!--<script>typeof(Popper) == undefined || document.write('<script src="/js/fallbackcdn/popper.min.js"><\/script>')</script>-->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>$.fn.modal || document.write('<script src="/js/fallbackcdn/bootstrap.min.js"><\/script>')</script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script>window.angular || document.write('<script src="/js/fallbackcdn/angular.min.js"><\/script>')</script>

    @yield('angular_slider')
    
    @yield('underscore')

    @yield('angular_sanitize')

    @yield('age_calculator')

    @yield('passdata')

    <script src="/js/app.js"></script>

    <script src="/js/functions/rate_by_index.js"></script>

    @yield('external_internal_data_merger')

    @yield('angular_controller_js')
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115767134-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-115767134-1');
    </script>

    @yield('adsense')
    <!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-5818851352711866",
        enable_page_level_ads: true
      });
    </script>-->
    
</head>


<?php
if(Auth::user()->margin_x_setting == 2) $full_screen = '-fluid px-1';
else if (Auth::user()->margin_x_setting == 1) $full_screen = '-fluid px-1 px-md-3 px-lg-5';
else $full_screen = '';

if(Auth::User()->theme==1) $theme='drk';
else $theme='';
?>
<body class="{{$theme}}" ng-cloak>

    <!--<div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/{{ app()->getLocale() }}_{{ strtoupper(app()->getLocale()) }}/sdk.js#xfbml=1&version=v2.11';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>-->


    <!--<a class="d-xl-inline" href="/">
        <img src="/images/topcorn_logo.png" class="indian-spot" alt="">
    </a>-->
    <nav class="navbar navbar-expand-md navbar-dark bg-night px-md-0 py-md-0 z-1041" ng-init="start_course='{{ __('navbar.start_course') }}';graduate='{{ __('navbar.graduate') }}'">
        <div class="container{{ $full_screen }}">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand p-0 ml-auto d-none d-md-inline" href="/">
                <img src="/images/topcorn_logo.png" width="66" height="66">
            </a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link d-md-none {{ Request::segment(1) === 'recommendations' ? 'active' : null }}" href="/recommendations"><i class="fa fa-th-list"></i><span class="d-none d-sm-inline"> {{ __('navbar.recommendations') }}</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link d-md-none {{ Request::segment(1) === 'search' ? 'active' : null }}" href="/search"><i class="fa fa-search"></i><span class="d-none d-sm-inline"> {{ __('navbar.search') }}</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button class="nav-link d-md-none text-warning btn btn-link" ng-click="quickvote()"><i class="far fa-star"></i><span class="d-none d-sm-inline"> {{ __('navbar.sequentialvote') }}</span></button>
                </li>
            </ul>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"
                            @if(Auth::User()->tt_navbar < 50)
                            data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="recommendations"
                            @endif
                        >
                        <a class="nav-link {{ Request::segment(1) === 'recommendations' ? 'active' : null }}" href="/recommendations"><i class="fa fa-th-list d-none d-md-inline"></i> {{ __('navbar.recommendations') }}</a>
                    </li>
                    <li class="nav-item"
                            @if(Auth::User()->tt_navbar < 50)
                            data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="search"
                            @endif
                        >
                        <a class="nav-link {{ Request::segment(1) === 'search' ? 'active' : null }}" href="/search"><i class="fa fa-search d-none d-md-inline"></i> {{ __('navbar.search') }}</a>
                    </li>
                    <li class="nav-item"
                            @if(Auth::User()->tt_navbar < 50)
                            data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="quickvote"
                            @endif
                        >
                        <button class="nav-link text-warning btn btn-link" ng-click="quickvote()"><i class="far fa-star d-none d-md-inline"></i> {{ __('navbar.sequentialvote') }}</button>
                        <div class="dropdown-divider d-md-none"></div>
                    </li>
                    <!--<li class="nav-item d-md-none {{ Request::segment(1) === 'profile' ? 'd-none' : null }}">
                        <a class="nav-link" href="/profile/{{ Auth::user()->id }}#Watch-Later">{{ __('navbar.watchlater') }}</a>
                    </li>-->
                    <li class="nav-item d-md-none">
                        <a class="nav-link {{ (Request::segment(1) === 'profile') && ($profile_user_id == Auth::user()->id) ? 'active' : null }}" href="/profile/{{ Auth::user()->id }}">{{ __('navbar.profile') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/account"><i class="fas fa-cog"></i> {{ __('navbar.account') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/theme/{{$theme}}"><i class="fas fa-moon"></i> {{ $theme==''?__('navbar.activate_nightmode'):__('navbar.deactivate_nightmode') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/faq">{{ __('navbar.faq') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/donation">{{ __('navbar.donation') }}</a>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link text-muted" href="{{ route('logout') }}" onclick="event.preventDefault();   document.getElementById('logout-form').submit();">{{ __('navbar.logout') }}</a>
                    </li>
                </ul>
                @if($watched_movie_number < 50)
                <ul class="navbar-nav mx-auto d-none d-md-inline" ng-if="watched_movie_number<50">
                    <li class="nav-item" data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="percentage">
                        <span class="navbar-brand">@{{percentage}}</span>
                    </li>
                </ul>
                @endif
                <ul class="navbar-nav ml-auto d-none d-md-flex">
                    <!--<li class="nav-item {{ Request::segment(1) === 'profile' ? 'd-none' : null }}">
                        <a class="nav-link" href="/profile/{{ Auth::user()->id }}#Watch-Later"><i class="fas fa-clock"></i> <span class="">{{ __('navbar.watchlater') }}</span></a>
                    </li>-->
                    <li class="nav-item"
                            @if(Auth::User()->tt_navbar < 50)
                            data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="profile"
                            @endif
                        >
                        <a class="nav-link {{ (Request::segment(1) === 'profile') && ($profile_user_id == Auth::user()->id) ? 'active' : null }}" href="/profile/{{ Auth::user()->id }}"><i class="far fa-user"></i> <span class="">{{ __('navbar.profile') }}</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link btn btn-link" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/account"><i class="fas fa-cog text-muted"></i> {{ __('navbar.account') }}</a>
                            <a class="dropdown-item" href="/theme/{{$theme}}"><i class="fas fa-moon text-muted"></i> {{ $theme==''?__('navbar.activate_nightmode'):__('navbar.deactivate_nightmode') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/faq">{{ __('navbar.faq') }}</a>
                            <a class="dropdown-item" href="/donation">{{ __('navbar.donation') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-muted" href="{{ route('logout') }}" onclick="event.preventDefault();   document.getElementById('logout-form').submit();">{{ __('navbar.logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>




    <div class="container{{ $full_screen }}">
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
                    <div class="py-2 small"><a class="text-dark" href="/donation"
                    @if(Auth::User()->tt_navbar < 100)
                    data-toggle="popover" data-placement="top" title='{{ __("tutorial.cry_for_help") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="donate"
                    @endif
                    >{{ __('navbar.donation') }}</a></div>
                </div>
                <div class="col col-sm-3 d-none d-sm-inline">
                    <div class="py-2 small"><a class="text-dark" href="/recommendations">{{ __('navbar.movie_recommendations') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/search">{{ __('navbar.movie_person_user_search') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/profile/{{ Auth::user()->id }}">{{ __('navbar.profile') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/account">{{ __('navbar.account') }}</a></div>
                </div>
                <div class="col-4 col-sm-2">
                    <div class="py-2 small"><a class="text-dark" href="/change_insta_language/en">English</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/change_insta_language/tr">Türkçe</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/change_insta_language/hu">Magyar</a></div>
                </div>
                <div class="col-8 col-sm-4 text-sm-right">
                    <div class=" h-100 d-flex flex-column justify-content-between">
                        <div class="py-2 small">
                            <!--<div class="text-dark pb-1">{{ __('navbar.like_us_on_facebook') }}</div>-->
                            <div class="d-inline"
                            @if(Auth::User()->tt_navbar < 100)
                            data-toggle="popover" data-placement="left" title='{{ __("tutorial.cry_for_help") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="like"
                            @endif
                            >
                                <!--<div class="fb-like mr-1 mb-2" data-href="https://www.facebook.com/topcorn.io/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>-->
                                <a class="btn btn-link btn-sm fa40 text-muted" href="{{config('constants.facebook.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}"><i class="fab fa-facebook-square"></i></a>
                            </div>
                            <!--<div class="fb-share-button" data-href="https://topcorn.io/" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Ftopcorn.io%2F&amp;src=sdkpreparse"></a></div>-->
                            <a class="btn btn-link btn-sm fa40 text-muted" href="{{config('constants.instagram.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-link btn-sm fa40 text-muted" href="{{config('constants.twitter.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}"><i class="fab fa-twitter-square"></i></a>
                        </div>
                        <div class="text-middle-light small py-2"><span>© 2018 {{ config('app.name') }}. {{ __('navbar.all_rights_reserved') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    



@include('layout.ratemodal')

@if(Auth::User()->tt_navbar < 100)
<div id="popover-content-quickvote" class="d-none">
    <p>{{ __("tutorial.quickvote1") }}</p>
    <p>{{ __("tutorial.quickvote2") }}</p>
    <div class="text-right">
        <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-sm btn-link d-inline" href="#tooltip-navbar-search">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-search" class="d-none">
    <p>{{ __("tutorial.search") }}</p>
    <div class="text-right">
        <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-sm btn-link d-inline" href="#tooltip-navbar-recommendations">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-recommendations" class="d-none">
    <p>{{ __("tutorial.recommendations") }}</p>
    <div class="text-right">
        <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-sm btn-link d-inline" href="#tooltip-navbar-profile">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-profile" class="d-none">
    <p>{{ __("tutorial.profile") }}</p>
    <div class="text-right">
        <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-sm btn-link d-inline" href="#tooltip-navbar-percentage">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-percentage" class="d-none">
    <p>{{ __("tutorial.percentage") }}</p>
    <div class="text-right">
        <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-sm btn-link d-inline" href="#navbar-tooltips-done">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-like" class="d-none">
    <p>{{ __("tutorial.like") }}</p>
    <div class="text-right">
        <a class="btn btn-sm btn-link d-inline" href="#tooltip-footer-donate">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-donate" class="d-none">
    <p>{{ __("tutorial.donate") }}</p>
    <div class="text-right">
        <a class="btn btn-sm btn-link d-inline" href="#navbar-tooltips-all-done">{{ __("tutorial.understood") }}</a>
    </div>
</div>
@endif
</body>
</html>