@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_series')

@section('body')
<!--Trailer Section-->
<div class="mt-md-4">
    <div class="position-relative">
        <div id="accordion">
            <div>
                <div id="collapseCover" class="collapse show" data-parent="#accordion">
                    <img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{page_variables.backdrop_path}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid trailercover" alt="Responsive image">
                    <div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-row no-gutters">
                            <div class="col pt-2 pl-2">
                                <span class="text-white h6 lead lead-small">@{{page_variables.number_of_seasons}} Seasons - @{{page_variables.number_of_episodes}} Episodes</span>
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
                        <div class="d-flex flex-row justify-content-between p-2">
                            <div class="d-flex flex-column justify-content-end ml-2 mb-2"><img ng-src="{{config('constants.image.svg')}}@{{page_variables.network_logo}}" on-error-src="" class="network-logo" alt=""></div>
                            <div ng-if="page_variables.vote_average > 0" class="text-right">
                                <div><span class="text-warning display-4 d-none d-md-inline">@{{page_variables.vote_average}}</span><span class="text-warning h5 d-md-none">@{{page_variables.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
                                <div><span class="text-white"><small>@{{page_variables.vote_count}}</small></span><span class="text-white"> <small><span ng-if="page_variables.vote_count > 1">votes</span></small></span></div>
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
                                <span class="text-white h6 lead lead-small">@{{page_variables.number_of_seasons}} Seasons - @{{page_variables.number_of_episodes}} Episodes</span>
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
                                    <button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == 0" ng-class="{'btn-trailer':current_trailer==0}" ng-click="previous_trailer();"><i class="fa fa-step-backward"></i></button>
                                    <button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == series.videos.results.length-1" ng-class="{'btn-trailer':current_trailer==series.videos.results.length-1}" ng-click="next_trailer();"><i class="fa fa-step-forward"></i></button>
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
                            <div ng-if="page_variables.vote_average > 0">
                                <div><span class="text-warning h4 d-none d-md-inline">@{{page_variables.vote_average}}</span><span class="text-warning h5 d-md-none">@{{page_variables.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
                                <div><span class="text-white"><small>@{{page_variables.vote_count}}</small></span><span class="text-white"> <small><span ng-if="page_variables.vote_count > 1">votes</span></small></span></div>
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
                    <h1 class="h4 pb-2 pt-3">@{{page_variables.name}}</h1>
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto pb-5">
        <div class="d-flex flex-row justify-content-between text-center">
            <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addlater text-nowrap" ng-class="{'text-warning':page_variables.later_id>0}" ng-click="this_later()"><div><span><i class="far fa-clock"></i></span></div>Watch Later</button>
            <button type="button" class="btn btn-sm btn-block border-0 mt-0 px-lg-4 addprimary" ng-class="rate_class(user_movie_record.rate_code)" ng-click="this_votemodal()"><div><span ng-show="!user_movie_record.rate_code>0"><i class="far fa-star"></i></span><span ng-show="user_movie_record.rate_code>0"><i class="fas fa-check"></i></span></div>Seen</button>
            <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-class="{'text-danger':page_variables.ban_id>0}" ng-click="this_ban()"><div><i class="fas fa-ban"></i></div>Ban</button>
            <a ng-href="{{config('constants.facebook.share_website')}}/series/{{$id}}" target="_blank" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addfacebook"><div><i class="fas fa-share"></i></div>Share</a>
        </div>
    </div>
</div>
<!--Under Trailer Section-->


<!-- Tabs_1 Button -->
<div class="container-fluid p-0 d-none d-md-inline">
    <ul class="nav justify-content-md-center tab1">
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted" ng-class="{'active':page_variables.active_tab_1==-1}" ng-click="page_variables.active_tab_1=-1;pull_data()">General Info</button>
        </li>
        <li class="nav-item" ng-repeat="season in page_variables.seasons">
            <button class="btn btn-link nav-link" ng-class="{'active':page_variables.active_tab_1==season.season_number, 'text-primary font-weight-bold':season.season_number==page_variables.last_seen_season, 'text-muted':season.season_number!=page_variables.last_seen_season}" ng-click="page_variables.active_tab_1=season.season_number;page_variables.active_tab_2=-1;pull_data()"><span ng-if="season.season_number != 0">S@{{season.season_number>9?season.season_number:'0'+season.season_number}}</span><span ng-if="season.season_number == 0">Specials</span></button>
        </li>
    </ul>
</div>
<!-- Tabs_1 Button -->

<!-- Tabs_1 Button Mobile -->
<div class="scrollmenu d-md-none tab2">
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':page_variables.active_tab_1==-1}" ng-click="page_variables.active_tab_1=-1;pull_data()">General Info</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-repeat="season in page_variables.seasons" ng-class="{'active':page_variables.active_tab_1==season.season_number, 'text-primary font-weight-bold':season.season_number==page_variables.last_seen_season, 'text-muted':season.season_number!=page_variables.last_seen_season}" ng-click="page_variables.active_tab_1=season.season_number;page_variables.active_tab_2=-1;pull_data()"><span ng-if="season.season_number != 0">S@{{season.season_number>9?season.season_number:'0'+season.season_number}}</span><span ng-if="season.season_number == 0">Specials</span></button>
</div>
<!-- Tabs_1 Button Mobile -->


<!-- Tabs_2 Button -->
<div class="container-fluid p-0 d-none d-md-inline" ng-if="page_variables.active_tab_1!=-1">
    <ul class="nav justify-content-md-center tab1">
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted" ng-class="{'active':page_variables.active_tab_2==-1}" ng-click="page_variables.active_tab_2=-1;pull_data()">Season Info</button>
        </li>
        <li class="nav-item" ng-repeat="episode in series.episodes">
            <button class="btn btn-link nav-link" ng-class="{'active':page_variables.active_tab_2==episode.episode_number,'text-primary font-weight-bold':episode.episode_number==page_variables.last_seen_episode, 'text-muted':episode.episode_number!=page_variables.last_seen_episode}" ng-click="page_variables.active_tab_2=episode.episode_number;pull_data()"><span>E@{{episode.episode_number>9?episode.episode_number:'0'+episode.episode_number}}</span></button>
        </li>
    </ul>
</div>
<!-- Tabs_2 Button -->

<!-- Tabs_2 Button Mobile -->
<div class="scrollmenu d-md-none tab2" ng-if="page_variables.active_tab_1!=-1">
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':page_variables.active_tab_2==-1}" ng-click="page_variables.active_tab_2=-1;pull_data()">Season Info</button>
    <button class="btn btn-link border-no-radius text-sm-center text-no-decoration" ng-repeat="episode in series.episodes" ng-class="{'active':page_variables.active_tab_2==episode.episode_number, 'text-primary font-weight-bold':episode.episode_number==page_variables.last_seen_episode, 'text-muted':episode.episode_number!=page_variables.last_seen_episode}" ng-click="page_variables.active_tab_2=episode.episode_number;pull_data()"><span>E@{{episode.episode_number>9?episode.episode_number:'0'+episode.episode_number}}</span></button>
</div>
<!-- Tabs_2 Button Mobile -->


<!--Poster Plot Details Section-->
<div class="p-5" ng-if="is_waiting">
    <div class="text-muted text-center">Loading...</div>
</div>
<div class="row no-gutters mt-3 mt-md-5 mb-md-5" ng-hide="is_waiting">
    <div class="col-12 col-md-3 col-lg-3" ng-if="page_variables.active_tab_1==-1 || page_variables.active_tab_2==-1">
        <img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{series.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top d-none d-md-inline" alt="Responsive image">
    </div>
    <div class="col-12 col-md-9 col-lg-6" ng-if="page_variables.active_tab_1==-1 || page_variables.active_tab_2==-1">
        <div class="container-fluid">
            <p class="h6 pt-3 pt-md-0" ng-if="page_variables.active_tab_1==-1">@{{series.first_air_date.substring(0, 4)}}-@{{series.status=='Ended'?series.last_air_date.substring(0, 4):''}} <span class="text-muted" ng-if="series.genres.length > 0" ng-class="{'ml-3':series.status!='Ended'}">•</span> <span ng-repeat="genre in series.genres"><span ng-if="$index!=0">, </span>@{{genre.name}}</span></p>
            <p class="h6 pt-3 pt-md-0" ng-if="page_variables.active_tab_1!=-1">@{{series.name}}</p>
            <div class="pt-2" ng-if="series.overview.length > 0"><p>@{{series.overview}}</p></div>
            <div class="pt-2" ng-if="series.overview.length == 0"><p>No overview found.</p></div>
            <div ng-if="page_variables.active_tab_1==-1">
                <div class="h6 pt-1"><span>Creators</span></div>
                <p><span class="d-inline" ng-repeat="creator in series.created_by"><span ng-if="$index!=0">, </span><a href="/person/@{{creator.id}}" target={{$target}} class="text-dark">@{{creator.name}}</a></span></p>
            </div>
            <div ng-if="page_variables.active_tab_1==-1 && series.networks.length>0">
                <div class="h6 pt-1"><span>Networks</span></div>
                <p><span class="d-inline" ng-repeat="network in series.networks"><span ng-if="$index!=0">, </span>@{{network.name}}</span></p>
            </div>
        </div>
    </div>
    <div class="col-3 d-none d-md-inline d-lg-none"></div>
    <div class="col-9 col-lg-3" ng-if="page_variables.active_tab_1==-1 || page_variables.active_tab_2==-1">
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
            <div ng-if="page_variables.active_tab_1==-1 && series.original_language.length > 0">
                <div class="h6 pt-1">Original Language</div>
                <p>@{{series.original_language}}</p>
            </div>
            <div ng-if="page_variables.active_tab_1==-1 && series.countries.length > 0">
                <div class="h6 pt-1"><span ng-if="series.countries.length == 1">Origin Country</span><span ng-if="series.countries.length > 1">Origin Countries</span></div>
                <p><span ng-repeat="country in series.countries"><span ng-if="$index!=0">, </span>@{{country}}</span></p>
            </div>
            <div ng-if="page_variables.active_tab_1==-1 && series.episode_run_time[0] > 0">
                <div class="h6 pt-1">{{ __('general.runtime') }}</div>
                <p>@{{series.episode_run_time[0]}} {{ __('general.minute') }} <small class="text-muted">(@{{fancyruntime.hour}}{{ __('general.h') }} @{{fancyruntime.minute}}{{ __('general.m') }})</small></p>
            </div>
            <div ng-if="series.last_episode_to_air">
                <div class="h6 pt-1">Last Episode</div>
                <p>S@{{series.last_episode_to_air.season_number>9?series.last_episode_to_air.season_number:'0'+series.last_episode_to_air.season_number}}E@{{series.last_episode_to_air.episode_number>9?series.last_episode_to_air.episode_number:'0'+series.last_episode_to_air.episode_number}} <span class="small text-muted">(@{{series.last_episode_to_air.air_date}})</span></p>
            </div>
            <div ng-if="series.next_episode_to_air">
                <div class="h6 pt-1">Next Episode</div>
                <p>S@{{series.next_episode_to_air.season_number>9?series.next_episode_to_air.season_number:'0'+series.next_episode_to_air.season_number}}E@{{series.next_episode_to_air.episode_number>9?series.next_episode_to_air.episode_number:'0'+series.next_episode_to_air.episode_number}} <span class="small text-muted">(@{{series.next_episode_to_air.air_date}})</span></p>
            </div>
            <div ng-if="series.external_ids.facebook_id.length>0 || series.external_ids.instagram_id.length>0 || series.external_ids.twitter_id.length>0">
                <div class="h6 pt-1">Links</div>
                <p>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.facebook.link')}}@{{series.external_ids.facebook_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}" ng-if="series.external_ids.facebook_id.length>0"><i class="fab fa-facebook-square"></i></a>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.instagram.link')}}@{{series.external_ids.instagram_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}" ng-if="series.external_ids.instagram_id.length>0"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.twitter.link')}}@{{series.external_ids.twitter_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}" ng-if="series.external_ids.twitter_id.length>0"><i class="fab fa-twitter-square"></i></a>
                </p>
            </div>
            <div ng-if="page_variables.active_tab_1!=-1">
                <div class="h6 pt-1">First Episode</div>
                <p>@{{series.air_date}}</p>
            </div>
            <div ng-if="page_variables.active_tab_1!=-1">
                <div class="h6 pt-1">Finale Date</div>
                <p>@{{series.episodes[series.episodes.length-1].air_date}}</p>
            </div>
            <div ng-if="page_variables.active_tab_1!=-1">
                <div class="h6 pt-1">Episodes</div>
                <p>@{{series.episodes.length}}</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7" ng-if="page_variables.active_tab_1!=-1 && page_variables.active_tab_2!=-1">
        <div class="container-fluid">
            <p class="h6 pt-3 pt-md-0">S@{{series.episodes[page_variables.active_tab_2-1].season_number>9?series.episodes[page_variables.active_tab_2-1].season_number:'0'+series.episodes[page_variables.active_tab_2-1].season_number}}E@{{series.episodes[page_variables.active_tab_2-1].episode_number>9?series.episodes[page_variables.active_tab_2-1].episode_number:'0'+series.episodes[page_variables.active_tab_2-1].episode_number}} • @{{series.episodes[page_variables.active_tab_2-1].name}}</p>
            <div class="pt-2" ng-if="series.episodes[page_variables.active_tab_2-1].overview.length > 0"><p>@{{series.episodes[page_variables.active_tab_2-1].overview}}</p></div>
            <div class="pt-2" ng-if="series.episodes[page_variables.active_tab_2-1].overview.length == 0"><p>No overview found.</p></div>
            <div>
                <div class="h6 pt-1"><span>Air Date</span></div>
                <p><span class="d-inline">@{{series.episodes[page_variables.active_tab_2-1].air_date}}</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5" ng-if="page_variables.active_tab_1!=-1 && page_variables.active_tab_2!=-1">
        <img src="{{config('constants.image.cover')[$image_quality]}}@{{series.episodes[page_variables.active_tab_2-1].still_path}}" on-error-src="" class="img-fluid" alt="Responsive image">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto">
                <div class="d-flex flex-row justify-content-between text-center">
                    <button type="button" class="btn btn-outline-dark btn-sm btn-block border-0 mt-0 px-lg-4 addprimary text-nowrap" ng-class="{'text-primary':page_variables.last_seen_season==page_variables.active_tab_1 && page_variables.last_seen_episode==page_variables.active_tab_2}" ng-click="toggle_last_Seen()"><div><span><i class="fas fa-check"></i></span></div>Last Seen Episode</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Poster Plot Details Section-->


<!--Cast Section-->
<div class="container-fluid px-0 mt-5" id="cast" ng-if="series.credits.cast.length > 0" ng-hide="is_waiting">
    <div class="px-3 px-md-0"><div class="h5">{{ __('general.actors') }}</div></div>
    <div class="">
        <div class="d-flex flex-wrap">
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.credits.cast | limitTo:6">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/person/@{{person.id}}" target={{$target}}>
                        <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">@{{person.name}}</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>@{{person.character}}</small></div>
                </div>
            </div>
        </div>
    </div>
    <div class="collapse" id="collapseCast">
        <div ng-if="series.credits.cast.length > 6">
            <div class="d-flex flex-wrap">
                <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.credits.cast | limitTo:100:6">
                    <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                        <a href="/person/@{{person.id}}" target={{$target}}>
                            <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                            <div class="card-block text-center">
                                <h6 class="card-title px-1 pt-1 text-dark" ng-if="person.name.length > 0">@{{person.name}}</h6>
                            </div>
                        </a>
                        <div class="card-title px-1 text-muted text-center mb-0"><small ng-if="person.character.length > 0">@{{person.character}}</small></div>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::check())
            @if(Auth::User()->show_crew)
        <div class="px-3 px-md-0 mt-5" ng-if="series.credits.crew.length > 0"><div class="h5">{{ __('general.crew') }}</div></div>
        <div ng-if="series.credits.crew.length > 0">
            <div class="d-flex flex-wrap">
                <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.credits.crew">
                    <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                        <a href="/person/@{{person.id}}" target={{$target}}>
                            <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                            <div class="card-block text-center">
                                <h6 class="card-title px-1 pt-1 text-dark" ng-if="person.name.length > 0">@{{person.name}}</h6>
                            </div>
                        </a>
                        <div class="card-title px-1 text-muted text-center mb-0"><small ng-if="person.job.length > 0">@{{person.job}}</small></div>
                    </div>
                </div>
            </div>
        </div>
            @endif
        @endif
    </div>
    @if(Auth::check())
        @if(Auth::User()->show_crew)
    <div ng-if="series.credits.cast.length > 6 || series.credits.crew.length > 0">
        @else
    <div ng-if="series.credits.cast.length > 6">
        @endif
    @else
    <div ng-if="series.credits.cast.length > 6">
    @endif
        <div class="text-center pt-1" ng-hide="iscast">
            <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast = true;" data-toggle="collapse" data-target="#collapseCast"><small>{{ __('general.show_everyone') }}</small></button>
        </div>
        <div class="text-center pt-1" ng-show="iscast">
            <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast = false;" data-toggle="collapse" data-target="#collapseCast"><i class="fa fa-angle-up"></i></button>
        </div>
    </div>
</div>
<!--Cast Section-->


<!--Cast Section-->
<div class="container-fluid px-0 mt-5" id="guest_stars" ng-if="series.episodes[page_variables.active_tab_2-1].guest_stars.length > 0" ng-hide="is_waiting">
    <div class="px-3 px-md-0"><div class="h5">Guest Stars</div></div>
    <div class="">
        <div class="d-flex flex-wrap">
            <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.episodes[page_variables.active_tab_2-1].guest_stars | limitTo:6">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a href="/person/@{{person.id}}" target={{$target}}>
                        <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                        <div class="card-block text-center">
                            <h6 class="card-title px-1 pt-1 text-dark">@{{person.name}}</h6>
                        </div>
                    </a>
                    <div class="card-title px-1 text-muted text-center mb-0"><small>@{{person.character}}</small></div>
                </div>
            </div>
        </div>
    </div>
    <div class="collapse" id="collapseGuestStars">
        <div ng-if="series.episodes[page_variables.active_tab_2-1].guest_stars.length > 6">
            <div class="d-flex flex-wrap">
                <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.episodes[page_variables.active_tab_2-1].guest_stars | limitTo:100:6">
                    <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                        <a href="/person/@{{person.id}}" target={{$target}}>
                            <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                            <div class="card-block text-center">
                                <h6 class="card-title px-1 pt-1 text-dark" ng-if="person.name.length > 0">@{{person.name}}</h6>
                            </div>
                        </a>
                        <div class="card-title px-1 text-muted text-center mb-0"><small ng-if="person.character.length > 0">@{{person.character}}</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center pt-1" ng-hide="iscast">
        <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast = true;" data-toggle="collapse" data-target="#collapseGuestStars"><small>Show All</small></button>
    </div>
    <div class="text-center pt-1" ng-show="iscast">
        <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast = false;" data-toggle="collapse" data-target="#collapseGuestStars"><i class="fa fa-angle-up"></i></button>
    </div>
</div>
<!--Cast Section-->

<!--Review Section-->
<div class="container-fluid px-0 mt-5" ng-if="page_variables.active_tab_1==-1" ng-hide="is_waiting"> 
    <div class="h5 px-3 px-md-0">
        <span class="mb-0 pr-2">{{ __('general.reviews') }}</span>
        <a href="https://www.themoviedb.org/tv/{{$id}}/reviews" class="btn btn-outline-success" target="_blank"><i class="fas fa-pencil-alt"></i> {{ __('general.add_review') }}</a>
    </div>
    <div class="container-fluid">
        <div ng-if="series.reviews.results.length>0" class="py-4" ng-repeat="review in series.reviews.results">
            <div class="h6 pb-2">@{{review.author}}</div>
            <div id="@{{'accordion'+$index}}">
                <div ng-if="review.id == 'long'">
                    <div id="@{{'collapse'+$index+'a'}}" data-parent="@{{'#accordion'+$index}}" class="lead lead-small collapse">
                        <div>
                            <div ng-bind-html="review.content"></div>
                        </div>
                        <div class="text-center pt-0">
                            <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white hidereview" data-toggle="collapse" data-target="@{{'#collapse'+$index+'b'}}" aria-expanded="true"><i class="fa fa-angle-up"></i></button>
                        </div>
                    </div>
                </div>
                <div>
                    <div id="@{{'collapse'+$index+'b'}}" data-parent="@{{'#accordion'+$index}}" class="lead lead-small collapse show">
                        <div>
                            <div ng-bind-html="review.url"></div>
                        </div>
                        <div ng-if="review.id == 'long'">
                            <div class="text-center pt-1">
                                <button class="btn btn-outline-secondary border-0 text-muted hover-white showreview" data-toggle="collapse" data-target="@{{'#collapse'+$index+'a'}}" aria-expanded="false"><small>{{ __('general.read_all') }}</small></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-5" ng-if="!series.reviews.results.length>0">
        <div class="text-muted text-center">{{ __('general.no_result_review') }}</div>
    </div>
</div>
<!--Review Section-->


<!--People Who Liked Also Liked Section-->
<div class="container-fluid px-0 mt-5" id="guest_stars" ng-if="similar_movies.length > 0" ng-hide="is_waiting">
    <div class="dropdown d-inline">
        <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle px-3 px-md-0 border-0 background-inherit" type="button" id="peopleWhoLikedAlsoLikedDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="h5">@{{page_variables.active_tab_3==0?'People Who Liked This Also Liked':'Similar Series'}}</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="peopleWhoLikedAlsoLikedDropdownButton">
            <button class="dropdown-item" ng-click="page_variables.active_tab_3='0';set_recommendations();">People Who Liked This Also Liked</button>
            <button class="dropdown-item" ng-click="page_variables.active_tab_3='1';set_recommendations();">Similar Series</button>
        </div>
    </div>
    <span class="text-muted pl-2"><small>Sorted by relevance</small></span>
    @include('layout.moviecard_6')
</div>
<!--People Who Liked Also Liked Section-->


@include('layout.this_ratemodal')
@endsection