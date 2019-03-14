<!doctype html>
<html lang="{{ app()->getLocale() }}">
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

    <link rel="icon" type="image/png" href="/images/topcorn_logo.png?v={{config('constants.version')}}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/style.css?v={{config('constants.version')}}">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/js/fallbackcdn/jquery-3.2.1.slim.min.js"><\/script>')</script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!--<script>window.FontAwesomeCdnConfig || document.write('<script src="/js/fallbackcdn/fontawesome.js"><\/script>')</script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!--<script>typeof(Popper) == undefined || document.write('<script src="/js/fallbackcdn/popper.min.js"><\/script>')</script>-->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script>$.fn.modal || document.write('<script src="/js/fallbackcdn/bootstrap.min.js"><\/script>')</script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115767134-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-115767134-1');
    </script>

    @yield('adsense')
</head>




<body>




    <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-night px-md-0 py-md-0 z-1041">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand p-0 ml-auto d-none d-md-inline" href="/main">
                <img src="/images/topcorn_logo.png" class="nav-logo">
            </a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link d-md-none {{ Request::segment(1) === 'recommendations' ? 'active' : null }}" href="/recommendations"><i class="fa fa-th-list"></i><span class="d-none d-sm-inline"> {{ __('navbar.recommendations') }}</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link d-md-none" href="/search"><i class="fa fa-search"></i><span class="d-none d-sm-inline"> {{ __('navbar.search') }}</span></a>
                </li>
            </ul>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/main"><i class="fas fa-home d-none d-md-inline"></i> {{ __('navbar.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/recommendations"><i class="fa fa-th-list d-none d-md-inline"></i> {{ __('navbar.recommendations') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search"><i class="fa fa-search d-none d-md-inline"></i> {{ __('navbar.search') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/profile/{{ Auth::user()->id }}">{{ __('navbar.profile') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/notifications">{{ __('navbar.notifications') }}<span class="badge badge-danger ml-1 {{App\Model\Notification::get_notification_button()==0?'d-none':''}}">{{App\Model\Notification::get_notification_button()}}</span></a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/account"><i class="fas fa-cog"></i> {{ __('navbar.account') }}</a>
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
                <ul class="navbar-nav ml-auto d-none d-md-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="/notifications"><i class="far fa-bell"></i><span class="badge badge-danger ml-1 {{App\Model\Notification::get_notification_button()==0?'d-none':''}}">{{App\Model\Notification::get_notification_button()}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile/{{ Auth::user()->id }}"><i class="far fa-user"></i> <span class="">{{ __('navbar.profile') }}</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link btn btn-link" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/account"><i class="fas fa-cog text-muted"></i> {{ __('navbar.account') }}</a>
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




    <div class="container">
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
                    <div class="py-2 small"><a class="text-dark" href="/main">{{ __('navbar.home') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/recommendations">{{ __('navbar.movie_recommendations') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/search">{{ __('navbar.movie_person_user_search') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/profile/{{ Auth::user()->id }}">{{ __('navbar.profile') }}</a></div>
                    <div class="py-2 small"><a class="text-dark" href="/notifications">{{ __('general.notifications') }}</a></div>
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
                            <div class="d-inline">
                                <a class="btn btn-link btn-sm fa40 text-muted" href="{{config('constants.facebook.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}"><i class="fab fa-facebook-square"></i></a>
                            </div>
                            <a class="btn btn-link btn-sm fa40 text-muted" href="{{config('constants.instagram.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-link btn-sm fa40 text-muted" href="{{config('constants.twitter.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}"><i class="fab fa-twitter-square"></i></a>
                        </div>
                        <div class="text-middle-light small py-2"><span>© 2019 {{ config('app.name') }}. {{ __('navbar.all_rights_reserved') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
