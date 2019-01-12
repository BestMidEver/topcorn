@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_series')

@section('body')
<!--Trailer Section-->
<div class="mt-md-4">
    <div class="position-relative">
        <div id="accordion">
            <div>
                <div id="collapseCover" class="collapse show" data-parent="#accordion">
                    <img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{series.backdrop_path}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid trailercover" alt="Responsive image">
                    <div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-row no-gutters">
                            <div class="col pt-2 pl-2">
                                <span class="text-white h6 lead lead-small">@{{series.number_of_seasons}} Seasons - @{{series.number_of_episodes}} Episodes</span>
                            </div>
                            <div class="col p-2 text-right">
                                <div ng-if="user_movie_record.percent > 0">
                                    <small class="text-white">{{ __("general.according_to_your_taste") }}</small>
                                    <div>
                                        <span class="text-warning display-4 d-none d-md-inline">%72</span><span class="text-warning h5 d-md-none">%72</span><span class="text-white"> <small>match</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-center" ng-if="series.videos.results.length > 0">
                            <button class="btn btn-link text-white btn-lg" ng-click="isfragman=true;scroll_to_top()" data-toggle="collapse" data-target="#collapseFragman" aria-expanded="false" aria-controls="collapseFragman"><i class="far fa-play-circle mr-2"></i><small>Videos</small></button>
                        </div>
                        <div class="d-flex flex-row justify-content-end p-2 text-right">
                            <div ng-if="series.vote_average > 0">
                                <div><span class="text-warning display-4 d-none d-md-inline">@{{series.vote_average}}</span><span class="text-warning h5 d-md-none">@{{series.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
                                <div><span class="text-white"><small>@{{series.vote_count}}</small></span><span class="text-white"> <small><span ng-if="series.vote_count > 1">votes</span></small></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div id="collapseFragman" class="collapse" data-parent="#accordion" ng-if="series.videos.results.length > 0">
                    <div class="d-flex flex-row background-black no-gutters pl-2 pt-2 pb-3">
                        <div class="col">
                            <div class="h-100 d-flex flex-column justify-content-center pl-2">
                                <span class="text-white h6 lead lead-small">8 Seasons - 94 Episodes</span>
                            </div>
                        </div>
                        <div class="col pb-2 pr-2 text-right">
                            <div ng-if="user_movie_record.percent > 0">
                                <div>
                                    <small class="text-white">According to your taste </small><span class="text-warning h4 d-none d-md-inline">%72</span><span class="text-warning h5 d-md-none">%72</span><span class="text-white"> <small>match</small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="embed-responsive embed-responsive-1by1 trailer">
                        <iframe class="embed-responsive-item" ng-src="@{{trailerurl}}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex flex-row background-black no-gutters">
                        <div class="col">
                            <div class="h-100 d-flex flex-column justify-content-center pl-2">
                                <div ng-if="series.videos.results.length > 1">
                                    <button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == 0" ng-click="previous_trailer();"><i class="fa fa-step-backward"></i></button>
                                    <button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == series.videos.results.length-1" ng-click="next_trailer();"><i class="fa fa-step-forward"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="h-100 d-flex flex-column justify-content-center text-center">
                                <div>
                                    <button class="btn btn-outline-secondary border-0 btn-lg fa40 text-muted hover-white" ng-click="isfragman = false" data-toggle="collapse" data-target="#collapseCover" aria-expanded="true" aria-controls="collapseCover"><i class="fa fa-angle-up"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col pb-2 pr-2 text-right">
                            <div ng-if="series.vote_average > 0">
                                <div><span class="text-warning h4 d-none d-md-inline">@{{series.vote_average}}</span><span class="text-warning h5 d-md-none">@{{series.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
                                <div><span class="text-white"><small>@{{series.vote_count}}</small></span><span class="text-white"> <small><span ng-if="series.vote_count > 1">votes</span></small></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Trailer Section-->

<!--Under Trailer Section-->
<div class="d-flex flex-wrap justify-content-between">
    <div>
        <div class="d-flex flex-column">
            <div class="px-3 px-md-0">
                <a class="text-dark" href="/" target="_blank">
                    <h1 class="h4 pb-2 pt-3">@{{series.name}}</h1>
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto">
        <div class="d-flex flex-row justify-content-between text-center">
            <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addlater text-nowrap" ng-click="this_later()"><div><span><i class="far fa-clock"></i></span></div>Watch Later</button>
            <button type="button" class="btn btn-sm btn-block border-0 mt-0 px-lg-4 addseen" ng-click=""><div><span><i class="fas fa-check"></i></span></div>Seen</button>
            <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-click="this_ban()"><div><i class="fas fa-ban"></i></div>Ban</button>
            <a ng-href="" target="_blank" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addfacebook"><div><i class="fas fa-share"></i></div>Share</a>
        </div>
    </div>
</div>
<!--Under Trailer Section-->


<!--Poster Plot Details Section-->
<div class="row no-gutters mt-3 mt-md-5 mb-md-5">
    <div class="col-12 col-md-3 col-lg-3">
        <img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{series.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top d-none d-md-inline" alt="Responsive image">
    </div>
    <div class="col-12 col-md-9 col-lg-6">
        <div class="container-fluid">
            <p class="h6 pt-3 pt-md-0">@{{series.first_air_date.substring(0, 4)}} <span class="text-muted" ng-if="series.genres.length > 0">•</span> <span ng-repeat="genre in series.genres"><span ng-if="$index!=0">, </span>@{{genre.name}}</span></p>
            <div class="pt-2" ng-if="series.overview.length > 0 && series.overview != 'No overview found.'"><p>@{{series.overview}}</p></div>
            <div>
                <div class="h6 pt-1"><span>Creators</span></div>
                <p><span class="d-inline" ng-repeat="creator in series.created_by"><span ng-if="$index!=0">, </span><a href="/person/@{{creator.id}}" target={{$target}} class="text-dark">@{{creator.name}}</a></span></p>
            </div>
            <div>
                <div class="h6 pt-1"><span>Status</span></div>
                <p><span class="d-inline">@{{series.status}}</span></p>
            </div>
        </div>
    </div>
    <div class="col-3 d-none d-md-inline d-lg-none"></div>
    <div class="col-9 col-lg-3">
        <div class="container-fluid">
            <div class="h5 d-none d-lg-inline">Details</div>
            <div ng-if="series.original_name.length > 0">
                <div class="h6 pt-2">{{ __('general.original_title') }}</div>
                <a class="text-dark" ng-href="http://www.google.com/search?q=@{{series.original_name}}" target="_blank"><p>@{{series.original_name}}</p></a>
            </div>
            <div ng-if="secondary_name.length > 0">
                <div class="h6 pt-1">@{{secondary_language}} {{ __('general.its_title') }}</div>
                <a class="text-dark" ng-href="http://www.google.com/search?q=@{{secondary_name}}" target="_blank"><p>@{{secondary_name}}</p></a>
            </div>
            <div>
                <div class="h6 pt-1">Original Language</div>
                <p>@{{series.original_language}}</p>
            </div>
            <div ng-if="series.countries.length > 0">
                <div class="h6 pt-1"><span ng-if="series.countries.length == 1">Origin Country</span><span ng-if="series.countries.length > 1">Origin Countries</span></span></div>
                <p><span ng-repeat="country in series.countries"><span ng-if="$index!=0">, </span>@{{country.name}}</span></p>
            </div>
            <div>
                <div class="h6 pt-1">Runtime</div>
                <p>43 Minutes</p>
            </div>
            <div>
                <div class="h6 pt-1">Networks</div>
                <p>HBO</p>
            </div>
            <div>
                <div class="h6 pt-1">Last Episode</div>
                <p><a class="text-dark" href="/" target="_blank">Apocalypse Then</a> <span class="small text-muted">(05/10/2011)</span></p>
            </div>
            <div>
                <div class="h6 pt-1">Next Episode</div>
                <p><a class="text-dark" href="/" target="_blank">Episode 1</a> <span class="small text-muted">(07/04/2019)</span></p>
            </div>
        </div>
    </div>
</div>
<!--Poster Plot Details Section-->

<!-- Tabs Button -->
<div class="container-fluid p-0 d-none d-md-inline">
    <ul class="nav justify-content-md-center tab1">
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">General Info</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted active">S01</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">S02</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">S03</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">S04</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">S05</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">S06</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">S07</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">S08</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">Specials</button>
        </li>
    </ul>
</div>
<!-- Tabs Button -->

<!-- Tabs Button Mobile -->
<div class="scrollmenu d-md-none tab2">
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration active">S01</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S02</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S03</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S04</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S05</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S06</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S07</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S08</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">Specials</button>
</div>
<!-- Tabs Button Mobile -->

<!--Poster Plot Details Section-->
<div class="row no-gutters mt-3 mt-md-5 mb-md-5">
    <div class="col-12 col-md-3 col-lg-3">
        <img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/kMTcwNRfFKCZ0O2OaBZS0nZ2AIe.jpg" on-error-src="" class="card-img-top d-none d-md-inline" alt="Responsive image">
    </div>
    <div class="col-12 col-md-9 col-lg-6">
        <div class="container-fluid">
            <p class="h6 pt-3 pt-md-0">Season 1</p>
            <div class="pt-2"><p>Trouble is brewing in the Seven Kingdoms of Westeros. For the driven inhabitants of this visionary world, control of Westeros' Iron Throne holds the lure of great power. But in a land where the seasons can last a lifetime, winter is coming...and beyond the Great Wall that protects them, an ancient evil has returned. In Season One, the story centers on three primary areas: the Stark and the Lannister families, whose designs on controlling the throne threaten a tenuous peace; the dragon princess Daenerys, heir to the former dynasty, who waits just over the Narrow Sea with her malevolent brother Viserys; and the Great Wall--a massive barrier of ice where a forgotten danger is stirring.</p></div>
        </div>
    </div>
    <div class="col-3 d-none d-md-inline d-lg-none"></div>
    <div class="col-9 col-lg-3">
        <div class="container-fluid">
            <div class="h5 d-none d-lg-inline">Details</div>
            <div>
                <div class="h6 pt-2">Hungarian Title</div>
                <a class="text-dark" href="/" target="_blank"><p>1. évad</p></a>
            </div>
            <div>
                <div class="h6 pt-1">First Episode</div>
                <p>2011-04-17</p>
            </div>
            <div>
                <div class="h6 pt-1">Finale Date</div>
                <p>2011-06-19</p>
            </div>
            <div>
                <div class="h6 pt-1">Episodes</div>
                <p>10</p>
            </div>
        </div>
    </div>
</div>
<!--Poster Plot Details Section-->

<!-- Tabs Button -->
<div class="container-fluid p-0 d-none d-md-inline">
    <ul class="nav justify-content-md-center tab1">
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted active">E01</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E02</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E03</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E04</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E05</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E06</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E07</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E08</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E09</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E10</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E11</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E12</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E13</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E14</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E15</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E16</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E17</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E18</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E19</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E20</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E21</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E22</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted">E23</button>
        </li>
    </ul>
</div>
<!-- Tabs Button -->

<!-- Tabs Button Mobile -->
<div class="scrollmenu d-md-none tab2">
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration active">S01</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S02</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S03</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S04</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S05</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S06</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S07</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">S08</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration">Specials</button>
</div>
<!-- Tabs Button Mobile -->

<div class="row no-gutters mt-3 my-md-5">
    <div class="col-12 col-md-6 col-lg-7">
        <div class="container-fluid">
            <p class="h6 pt-3 pt-md-0">S03E13 • A Man Without Honor</p>
            <div class="pt-2"><p>Jamie meets a distant relative. Daenerys receives an invitation to the House of the Undying. Theon leads a search party. Jon loses his way in the wilderness. Cersei counsels Sansa.</p></div>
            <div>
                <div class="h6 pt-1"><span>Air Date</span></div>
                <p><span class="d-inline">2012-05-13 <span class="small text-muted">(6 years ago)</span></span></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-5">
        <img src="https://image.tmdb.org/t/p/w1280/d7hTn2ltWb9RMXLycP1TSQTIPG8.jpg" on-error-src="" class="img-fluid" alt="Responsive image">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto">
                <div class="d-flex flex-row justify-content-between text-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addlater text-nowrap" ng-click="this_later()"><div><span><i class="fas fa-check"></i></span></div>Last Seen Episode</button>
                </div>
            </div>
        </div>
    </div>
</div>



<!--Cast Section-->
<div>
<div class="container-fluid px-0 mt-5" id="cast">
    <div class="px-3 px-md-0"><div class="h5">Cast</div></div>
    <div class="">
        <div class="d-flex flex-wrap">
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/neWvvnFVWVWmo7bXsUdrbvJIFHF.jpg">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">Emilia Clarke</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>Daenerys Targaryen</small></div>
                </div>
            </div>
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4MqUjb1SYrzHmFSyGiXnlZWLvBs.jpg">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">Kit Harington</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>Jon Snow</small></div>
                </div>
            </div>
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/xuB7b4GbARu4HN6gq5zMqjGbkwF.jpg">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">Peter Dinklage</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>Tyrion Lannister</small></div>
                </div>
            </div>
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/wcpy6J7KLzmVt0METboX3CZ0Jp.jpg">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">Lena Headey</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>Cersei Lannister</small></div>
                </div>
            </div>
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/3xv7t3Uyx4RNLB8MnPQMIhuRV9V.jpg">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">Nikolaj Coster-Waldau</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>Jaime Lannister</small></div>
                </div>
            </div>
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/ed4ajSYdv49j9OF7yMeG8Hznrrt.jpg">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">Sophie Turner</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>Sansa Stark</small></div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="text-center pt-1" ng-hide="iscast">
            <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast = true;" data-toggle="collapse" data-target="#collapseCast"><small>Show Full Cast</small></button>
        </div>
    </div>
</div>
</div>
<!--Cast Section-->
@endsection