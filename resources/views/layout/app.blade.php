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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/style.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/js/fallbackcdn/jquery-3.2.1.slim.min.js"><\/script>')</script>

    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script>window.FontAwesomeCdnConfig || document.write('<script src="/js/fallbackcdn/fontawesome.js"><\/script>')</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script>typeof(Popper) == undefined || document.write('<script src="/js/fallbackcdn/popper.min.js"><\/script>')</script>

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



    <?php
    if(Auth::user()->margin_x_setting == 2) $full_screen = '-fluid px-1';
    else if (Auth::user()->margin_x_setting == 1) $full_screen = '-fluid px-1 px-md-3 px-lg-5';
    else $full_screen = '';
    ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-ddd px-md-0 z-1041" ng-init="start_course='{{ __('navbar.start_course') }}';graduate='{{ __('navbar.graduate') }}'">
        <div class="container{{ $full_screen }}">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
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
                            data-toggle="popover" title='Tavsiyeler<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="recommendations"
                            @endif
                        >
                        <a class="nav-link {{ Request::segment(1) === 'recommendations' ? 'active' : null }}" href="/recommendations"><i class="fa fa-th-list d-none d-md-inline"></i> {{ __('navbar.recommendations') }}</a>
                    </li>
                    <li class="nav-item"
                            @if(Auth::User()->tt_navbar < 50)
                            data-toggle="popover" title='Arama Yapma<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="search"
                            @endif
                        >
                        <a class="nav-link {{ Request::segment(1) === 'search' ? 'active' : null }}" href="/search"><i class="fa fa-search d-none d-md-inline"></i> {{ __('navbar.search') }}</a>
                    </li>
                    <li class="nav-item"
                            @if(Auth::User()->tt_navbar < 50)
                            data-toggle="popover" title='Hızlı Oylama<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="quickvote"
                            @endif
                        >
                        <button class="nav-link text-warning btn btn-link" ng-click="quickvote()"><i class="far fa-star d-none d-md-inline"></i> {{ __('navbar.sequentialvote') }}</button>
                        <div class="dropdown-divider d-md-none"></div>
                    </li>
                    <li class="nav-item d-md-none {{ Request::segment(1) === 'profile' ? 'd-none' : null }}">
                        <a class="nav-link" href="/profile/{{ Auth::user()->id }}#Watch-Later">{{ __('navbar.watchlater') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link {{ Request::segment(1) === 'profile' ? 'active' : null }}" href="/profile/{{ Auth::user()->id }}">{{ __('navbar.profile') }}</a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link" href="/account">{{ __('navbar.account') }}</a>
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
                    <li class="nav-item" data-toggle="popover" title='Profilini Tamamla<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="percentage">
                        <span class="navbar-brand">@{{percentage}}</span>
                    </li>
                </ul>
                @endif
                <ul class="navbar-nav ml-auto d-none d-md-flex">
                    <li class="nav-item {{ Request::segment(1) === 'profile' ? 'd-none' : null }}">
                        <a class="nav-link" href="/profile/{{ Auth::user()->id }}#Watch-Later"><i class="fas fa-clock"></i> <span class="">{{ __('navbar.watchlater') }}</span></a>
                    </li>
                    <li class="nav-item"
                            @if(Auth::User()->tt_navbar < 50)
                            data-toggle="popover" title='Profilin<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="profile"
                            @endif
                        >
                        <a class="nav-link {{ Request::segment(1) === 'profile' ? 'active' : null }}" href="/profile/{{ Auth::user()->id }}"><i class="far fa-user"></i> <span class="">{{ __('navbar.profile') }}</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link btn btn-link" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/account">{{ __('navbar.account') }}</a>
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
                    <div class="py-2 small"><a class="text-dark" href="/donation">{{ __('navbar.donation') }}</a></div>
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
    



@include('layout.ratemodal')




    @if(Auth::User()->tt_navbar < 50)
    <div id="popover-content-quickvote" class="d-none">
        <p>Sen ne kadar çok film oylarsan, seni o kadar iyi tanırız. Peş Peşe Oylama da seni daha hızlı tanımamızı sağlıyor.</p>
        <p>Tek yapman gereken, filmi izlediysen sana yakın gelen şeçeneği işaretlemek.</p>
        <div class="text-right">
            <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">İpuçlarını Gösterme</a>
            <a class="btn btn-sm btn-link d-inline" href="#tooltip-search">Anladım</a>
        </div>
    </div>
    <div id="popover-content-search" class="d-none">
        <p>"Yok benim belli filmlerim var. Beni oradan tanı." dersen de, hemen sol üstten dilediğin filmi aratıp izledim butonuyla oylama yapabilirsin.</p>
        <div class="text-right">
            <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">İpuçlarını Gösterme</a>
            <a class="btn btn-sm btn-link d-inline" href="#tooltip-recommendations">Anladım</a>
        </div>
    </div>
    <div id="popover-content-recommendations" class="d-none">
        <p>İşte en güzel yerdeyiz! Bu linkten tam senlik filmlere sol baştan sıralı olarak ulaşabilirsin.</p>
        <div class="text-right">
            <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">İpuçlarını Gösterme</a>
            <a class="btn btn-sm btn-link d-inline" href="#tooltip-profile">Anladım</a>
        </div>
    </div>
    <div id="popover-content-profile" class="d-none">
        <p>Profilini sevdiğin filmlerin görselleriyle kişiselleştirebilirsin. Ama unutma, ne kadar çok film oylarsan, o kadar çok verim alırsın.</p>
        <div class="text-right">
            <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">İpuçlarını Gösterme</a>
            <a class="btn btn-sm btn-link d-inline" href="#tooltip-percentage">Anladım</a>
        </div>
    </div>
    <div id="popover-content-percentage" class="d-none">
        <p>Profilini tamamlamak için en az 50 film oylamalısın. Korkma hepsini şimdi oylamak zorunda değilsin.</p>
        <div class="text-right">
            <a class="btn btn-sm btn-link d-inline text-muted" href="#cancel-tooltips">İpuçlarını Gösterme</a>
            <a class="btn btn-sm btn-link d-inline" href="#navbar-tooltips-done">Anladım</a>
        </div>
    </div>
    @endif
</body>
</html>