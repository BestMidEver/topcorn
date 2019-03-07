@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_series')

@section('body')
<!--Trailer Section-->
<div class="mt-md-4">
    <div class="position-relative">
        <div id="accordion">
            <div>
                <div id="collapseCover" class="collapse show" data-parent="#accordion">
                    <img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{movie.backdrop_path}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid trailercover" alt="Responsive image">
                    <div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-row no-gutters">
                            <div class="col pt-2 pl-2">
                                <span class="text-white h6 lead lead-small" ng-show="movie.number_of_seasons>0">@{{movie.number_of_seasons}} <span ng-show="movie.number_of_seasons>1">{{ __("general.seasons") }}</span><span ng-show="movie.number_of_seasons==1">{{ __("general.season") }}</span> - @{{movie.number_of_episodes}} <span ng-show="movie.number_of_episodes>1">{{ __("general.episodes") }}</span><span ng-show="movie.number_of_episodes==1">{{ __("general.episode") }}</span></span>
                            </div>
                            <div class="col p-2 text-right">
                                <div ng-show="user_movie_record.percent > 0">
                                    <small class="text-white">{{ __("general.according_to_your_taste") }}</small>
                                    <div>
                                        <span class="text-warning display-4 d-none d-md-inline">{!! __('general.moviecard_percent', ['suffix' => 'user_movie_record.percent']) !!}</span><span class="text-warning h5 d-md-none">{!! __('general.moviecard_percent', ['suffix' => 'user_movie_record.percent']) !!}</span><span class="text-white"> <small>{{ __("general.match") }}</small></span>
                                    </div>
                                    @if(Auth::check())
                                        @if(Auth::User()->advanced_filter)
                                    <div>
                                        <span class="text-white"><small>@{{user_movie_record.point*1+user_movie_record.p2*1}}/@{{user_movie_record.p2*2}}</small></span><span class="text-white"> <small>{{ __("general.point") }}</small></span>
                                    </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-center" ng-show="series.videos.results.length > 0">
                            <button class="btn btn-link text-white btn-lg" ng-click="isfragman=true;scroll_to_top()" data-toggle="collapse" data-target="#collapseFragman" aria-expanded="false" aria-controls="collapseFragman"><i class="far fa-play-circle mr-2"></i><small>{{ __('general.trailer') }}</small></button>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-2">
                            <div class="d-flex flex-column justify-content-end ml-2 mb-2"><img ng-src="{{config('constants.image.original')}}@{{page_variables.network_logo}}" on-error-src="" class="network-logo" alt=""></div>
                            <div ng-show="movie.vote_average > 0" class="text-right">
                                <div><span class="text-warning display-4 d-none d-md-inline">@{{movie.vote_average}}</span><span class="text-warning h5 d-md-none">@{{movie.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
                                <div><span class="text-white"><small>@{{movie.vote_count}}</small></span><span class="text-white"> <small><span ng-show="movie.vote_count == 1">{{ __('general.person_time') }}</span><span ng-show="movie.vote_count > 1">{{ __('general.person_times') }}</span></small></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div id="collapseFragman" class="collapse" data-parent="#accordion" ng-show="series.videos.results.length > 0">
                    <div class="d-flex flex-row background-black no-gutters pl-2 pt-2 pb-3">
                        <div class="col">
                            <div class="h-100 d-flex flex-column justify-content-center pl-2">
                                <span class="text-white h6 lead lead-small" ng-show="movie.number_of_seasons>0">@{{movie.number_of_seasons}} <span ng-show="movie.number_of_seasons>1">{{ __("general.seasons") }}</span><span ng-show="movie.number_of_seasons==1">{{ __("general.season") }}</span> - @{{movie.number_of_episodes}} <span ng-show="movie.number_of_episodes>1">{{ __("general.episodes") }}</span><span ng-show="movie.number_of_episodes==1">{{ __("general.episode") }}</span></span>
                            </div>
                        </div>
                        <div class="col pb-2 pr-2 text-right">
                            <div ng-show="user_movie_record.percent > 0">
                                <div>
                                    <small class="text-white">{{ __("general.according_to_your_taste") }} </small><span class="text-warning h4 d-none d-md-inline">{!! __('general.moviecard_percent', ['suffix' => 'user_movie_record.percent']) !!}</span><span class="text-warning h5 d-md-none">{!! __('general.moviecard_percent', ['suffix' => 'user_movie_record.percent']) !!}</span><span class="text-white"> <small>{{ __("general.match") }}</small></span>
                                </div>
                                @if(Auth::check())
                                    @if(Auth::User()->advanced_filter)
                                <div>
                                    <span class="text-white"><small>@{{user_movie_record.point*1+user_movie_record.p2*1}}/@{{user_movie_record.p2*2}}</small></span><span class="text-white"> <small>{{ __("general.point") }}</small></span>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="embed-responsive embed-responsive-1by1 trailer">
                        <iframe class="embed-responsive-item" ng-src="@{{trailerurl}}" allowfullscreen></iframe>
                    </div>
                    <div class="d-flex flex-row background-black no-gutters">
                        <div class="col">
                            <div class="h-100 d-flex flex-column justify-content-center pl-2">
                                <div ng-show="series.videos.results.length > 1">
                                    <button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == 0" ng-class="{'btn-trailer':current_trailer==0}" ng-click="previous_trailer();"><i class="fa fa-step-backward"></i></button>
                                    <button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == series.videos.results.length-1" ng-class="{'btn-trailer':current_trailer==series.videos.results.length-1}" ng-click="next_trailer();"><i class="fa fa-step-forward"></i></button>
                                    <div class="dropdown d-none d-md-inline" ng-show="series.videos.results.length>1">
                                        <button class="btn btn-outline-secondary border-0 btn-lg hover-white dropdown-toggle" type="button" id="dropdownchoosetrailer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownchoosetrailer">
                                            <a class="dropdown-item" ng-repeat="trailer in series.videos.results" ng-click="change_trailer($index)">@{{trailer.name}}</a>
                                        </div>
                                    </div>
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
                            <div ng-show="movie.vote_average > 0">
                                <div><span class="text-warning h4 d-none d-md-inline">@{{movie.vote_average}}</span><span class="text-warning h5 d-md-none">@{{movie.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
                                <div><span class="text-white"><small>@{{movie.vote_count}}</small></span><span class="text-white"> <small><span ng-show="movie.vote_count == 1">{{ __('general.person_time') }}</span><span ng-show="movie.vote_count > 1">{{ __('general.person_times') }}</span></small></span></div>
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
                <a class="text-dark" ng-href="http://www.google.com/search?q=@{{movie.name+' '+series.first_air_date.substring(0, 4)}}" target="_blank">
                    <h1 class="h4 pb-2 pt-3">@{{movie.name}}</h1>
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto pb-5">
        <div class="d-flex flex-row justify-content-between text-center">
            @if(Auth::check())
            <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban text-nowrap" ng-class="{'text-warning':user_movie_record.later_id>0}" ng-click="this_later()"><div><span><i class="far fa-clock"></i></span></div><span class="scrollmenu">{{ __('general.watch_later') }}</span></button>
            <button type="button" class="btn btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-class="rate_class(user_movie_record.rate_code)" ng-click="this_votemodal()"><div><span ng-show="!user_movie_record.rate_code>0"><i class="far fa-star"></i></span><span ng-show="user_movie_record.rate_code>0"><i class="fas fa-check"></i></span></div>{{ __('general.seen') }}</button>
            <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-class="{'text-danger':user_movie_record.ban_id>0}" ng-click="this_ban()"><div><i class="fas fa-ban"></i></div>{{ __('general.ban') }}</button>
            <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-click="open_share_modal()"><div><i class="fas fa-share"></i></div>{{ __('general.share') }}</button>
            @endif
            @if(Auth::guest())
            <a ng-href="{{config('constants.facebook.share_website')}}/series/{{$id}}" target="_blank" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban"><div><i class="fas fa-share"></i></div>{{ __('general.share') }}</a>
            @endif
        </div>
    </div>
</div>
<!--Under Trailer Section-->

<div class="my-2 d-flex justify-content-center">
    <input type="hidden" name="IL_IN_ARTICLE">
</div>


<!-- Tabs_1 Button -->
<div class="container-fluid p-0 d-none d-md-inline">
    <ul class="nav justify-content-md-center tab1">
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted" ng-class="{'active':page_variables.active_tab_1==-1}" ng-click="page_variables.active_tab_1=-1;page_variables.active_tab_2==-1;pull_data()">{{ __('general.general_info') }}</button>
        </li>
        <li class="nav-item" ng-repeat="season in movie.seasons">
            <button class="btn btn-link nav-link" ng-class="{'active':page_variables.active_tab_1==season.season_number, 'text-primary font-weight-bold':season.season_number==user_movie_record.last_seen_season, 'text-muted':season.season_number!=user_movie_record.last_seen_season}" ng-click="page_variables.active_tab_1=season.season_number;page_variables.active_tab_2=-1;pull_data()"><span ng-show="season.season_number != 0">S@{{season.season_number>9?season.season_number:'0'+season.season_number}}</span><span ng-show="season.season_number == 0">{{ __('general.specials') }}</span></button>
        </li>
    </ul>
</div>
<!-- Tabs_1 Button -->

<!-- Tabs_1 Button Mobile -->
<div class="scrollmenu d-md-none tab2">
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':page_variables.active_tab_1==-1}" ng-click="page_variables.active_tab_1=-1;page_variables.active_tab_2==-1;pull_data()">{{ __('general.general_info') }}</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-repeat="season in movie.seasons" ng-class="{'active':page_variables.active_tab_1==season.season_number, 'text-primary font-weight-bold':season.season_number==user_movie_record.last_seen_season, 'text-muted':season.season_number!=user_movie_record.last_seen_season}" ng-click="page_variables.active_tab_1=season.season_number;page_variables.active_tab_2=-1;pull_data()"><span ng-show="season.season_number != 0">S@{{season.season_number>9?season.season_number:'0'+season.season_number}}</span><span ng-show="season.season_number == 0">{{ __('general.specials') }}</span></button>
</div>
<!-- Tabs_1 Button Mobile -->


<!-- Tabs_2 Button -->
<div class="container-fluid p-0 d-none d-md-inline" ng-show="page_variables.active_tab_1!=-1">
    <ul class="nav justify-content-md-center tab1">
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted" ng-class="{'active':page_variables.active_tab_2==-1}" ng-click="page_variables.active_tab_2=-1;pull_data()">{{ __('general.season_info') }}</button>
        </li>
        <li class="nav-item" ng-repeat="episode in series.episodes">
            <button class="btn btn-link nav-link" ng-class="{'active':page_variables.active_tab_2==episode.episode_number,'font-weight-bold text-primary':(page_variables.active_tab_1==user_movie_record.last_seen_season && episode.episode_number==user_movie_record.last_seen_episode), 'text-muted':!(page_variables.active_tab_1==user_movie_record.last_seen_season && episode.episode_number==user_movie_record.last_seen_episode)}" ng-click="page_variables.active_tab_2=episode.episode_number;pull_data()"><span>E@{{episode.episode_number>9?episode.episode_number:'0'+episode.episode_number}}</span></button>
        </li>
    </ul>
</div>
<!-- Tabs_2 Button -->

<!-- Tabs_2 Button Mobile -->
<div class="scrollmenu d-md-none tab2" ng-show="page_variables.active_tab_1!=-1">
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':page_variables.active_tab_2==-1}" ng-click="page_variables.active_tab_2=-1;pull_data()">{{ __('general.season_info') }}</button>
    <button class="btn btn-link border-no-radius text-sm-center text-no-decoration" ng-repeat="episode in series.episodes" ng-class="{'active':page_variables.active_tab_2==episode.episode_number,'font-weight-bold text-primary':(page_variables.active_tab_1==user_movie_record.last_seen_season && episode.episode_number==user_movie_record.last_seen_episode), 'text-muted':!(page_variables.active_tab_1==user_movie_record.last_seen_season && episode.episode_number==user_movie_record.last_seen_episode)}" ng-click="page_variables.active_tab_2=episode.episode_number;pull_data()"><span>E@{{episode.episode_number>9?episode.episode_number:'0'+episode.episode_number}}</span></button>
</div>
<!-- Tabs_2 Button Mobile -->


<!--Poster Plot Details Section-->
<div class="p-5" ng-show="is_waiting">
    <div class="text-muted text-center">{{ __('general.loading') }}</div>
</div>
<div class="row no-gutters mt-3 mt-md-5 mb-md-5" ng-hide="is_waiting">
    <div class="col-12 col-md-3 col-lg-3" ng-show="page_variables.active_tab_1==-1 || page_variables.active_tab_2==-1">
        <img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{series.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top d-none d-md-inline" alt="Responsive image">
    </div>
    <div class="col-12 col-md-9 col-lg-6" ng-show="page_variables.active_tab_1==-1 || page_variables.active_tab_2==-1">
        <div class="container-fluid">
            <p class="h6 pt-3 pt-md-0" ng-show="page_variables.active_tab_1==-1"><span data-toggle="tooltip" data-placement="top" data-original-title="@{{series.first_air_date}}">@{{series.first_air_date.substring(0, 4)}}</span>-<span data-toggle="tooltip" data-placement="top" data-original-title="@{{series.last_air_date}}">@{{series.status!='Returning Series'?series.last_air_date.substring(0, 4):''}}</span> <span class="text-muted" ng-show="series.genres.length > 0" ng-class="{'ml-3':series.status=='Returning Series'}">•</span> <span ng-repeat="genre in series.genres"><span ng-show="$index!=0">, </span>@{{genre.name}}</span></p>
            <p class="h6 pt-3 pt-md-0" ng-show="page_variables.active_tab_1!=-1">@{{series.name}}</p>
            <div class="pt-2" ng-show="series.overview.length > 0"><p>@{{series.overview}}</p></div>
            <div class="pt-2" ng-show="series.overview.length == 0"><p>{{ __('general.no_overview_found') }}</p></div>
            <div ng-show="page_variables.active_tab_1==-1 && series.created_by.length>0">
                <div class="h6 pt-1"><span>{{ __('general.creators') }}</span></div>
                <p><span class="d-inline" ng-repeat="creator in series.created_by"><span ng-show="$index!=0">, </span><a href="/person/@{{creator.id}}" target={{$target}} class="text-dark">@{{creator.name}}</a></span></p>
            </div>
            <div ng-show="page_variables.active_tab_1==-1 && series.networks.length>0">
                <div class="h6 pt-1"><span>{{ __('general.networks') }}</span></div>
                <p>
                    <span class="d-inline" ng-repeat="network in series.networks"><span ng-show="$index!=0">, </span>@{{network.name}}</span>
                    <span class="ml-1 text-muted" ng-show="series.status=='Returning Series'">({{ __('general.continuing') }})</span>
                    <span class="ml-1 text-muted" ng-show="series.status=='Ended'">({{ __('general.ended') }})</span>
                    <span class="ml-1 text-muted" ng-show="series.status=='Canceled'">({{ __('general.canceled') }})</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-3 d-none d-md-inline d-lg-none"></div>
    <div class="col-9 col-lg-3" ng-show="page_variables.active_tab_1==-1 || page_variables.active_tab_2==-1">
        <div class="container-fluid">
            <div class="h5 d-none d-lg-inline">{{ __('general.details') }}</div>
            <div ng-show="series.original_name.length > 0">
                <div class="h6 pt-2">{{ __('general.original_name') }}</div>
                <a class="text-dark" ng-href="http://www.google.com/search?q=@{{series.original_name}}" target="_blank"><p>@{{series.original_name}}</p></a>
            </div>
            <div ng-show="secondary_name.length > 0">
                <div class="h6 pt-1">@{{secondary_language}} {{ __('general.its_title') }}</div>
                <a class="text-dark" ng-href="http://www.google.com/search?q=@{{secondary_name}}" target="_blank"><p>@{{secondary_name}}</p></a>
            </div>
            <div ng-show="page_variables.active_tab_1==-1 && series.original_language.length > 0">
                <div class="h6 pt-1">{{ __('general.original_language') }}</div>
                <p>@{{series.original_language}}</p>
            </div>
            <div ng-show="page_variables.active_tab_1==-1 && series.countries.length > 0">
                <div class="h6 pt-1"><span ng-show="series.countries.length == 1">{{ __('general.origin_country') }}</span><span ng-show="series.countries.length > 1">{{ __('general.origin_countries') }}</span></div>
                <p><span ng-repeat="country in series.countries"><span ng-show="$index!=0">, </span>@{{country}}</span></p>
            </div>
            <div ng-show="page_variables.active_tab_1==-1 && series.episode_run_time[0] > 0">
                <div class="h6 pt-1">{{ __('general.runtime') }}</div>
                <p>@{{series.episode_run_time[0]}} {{ __('general.time_minutes') }} <small class="text-muted">(@{{fancyruntime.hour}}{{ __('general.h') }} @{{fancyruntime.minute}}{{ __('general.m') }})</small></p>
            </div>
            <div ng-show="series.last_episode_to_air">
                <div class="h6 pt-1">{{ __('general.last_episode') }}</div>
                <p>S@{{series.last_episode_to_air.season_number>9?series.last_episode_to_air.season_number:'0'+series.last_episode_to_air.season_number}}E@{{series.last_episode_to_air.episode_number>9?series.last_episode_to_air.episode_number:'0'+series.last_episode_to_air.episode_number}} <span class="small text-muted">(@{{series.last_episode_to_air.air_date}})</span></p>
            </div>
            <div ng-show="series.next_episode_to_air">
                <div class="h6 pt-1">{{ __('general.next_episode') }}</div>
                <p>S@{{series.next_episode_to_air.season_number>9?series.next_episode_to_air.season_number:'0'+series.next_episode_to_air.season_number}}E@{{series.next_episode_to_air.episode_number>9?series.next_episode_to_air.episode_number:'0'+series.next_episode_to_air.episode_number}} <span class="small text-muted">(@{{series.next_episode_to_air.air_date}})</span></p>
            </div>
            <div ng-show="series.external_ids.facebook_id.length>0 || series.external_ids.instagram_id.length>0 || series.external_ids.twitter_id.length>0">
                <div class="h6 pt-1">{{ __('general.links') }}</div>
                <p>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.facebook.link')}}@{{series.external_ids.facebook_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}" ng-show="series.external_ids.facebook_id.length>0"><i class="fab fa-facebook-square"></i></a>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.instagram.link')}}@{{series.external_ids.instagram_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}" ng-show="series.external_ids.instagram_id.length>0"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.twitter.link')}}@{{series.external_ids.twitter_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}" ng-show="series.external_ids.twitter_id.length>0"><i class="fab fa-twitter-square"></i></a>
                </p>
            </div>
            <div ng-show="page_variables.active_tab_1!=-1 && series.air_date.length>0">
                <div class="h6 pt-1">{{ __('general.first_episode') }}</div>
                <p>@{{series.air_date}}</p>
            </div>
            <div ng-show="page_variables.active_tab_1!=-1 && series.episodes[series.episodes.length-1].air_date.length>0">
                <div class="h6 pt-1">{{ __('general.finale_date') }}</div>
                <p>@{{series.episodes[series.episodes.length-1].air_date}}</p>
            </div>
            <div ng-show="page_variables.active_tab_1!=-1 && series.episodes.length>0">
                <div class="h6 pt-1">{{ __('general.episodes') }}</div>
                <p>@{{series.episodes.length}}</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-7" ng-show="page_variables.active_tab_1!=-1 && page_variables.active_tab_2!=-1">
        <div class="container-fluid">
            <p class="h6 pt-3 pt-md-0">S@{{series.episodes[page_variables.active_tab_2-1].season_number>9?series.episodes[page_variables.active_tab_2-1].season_number:'0'+series.episodes[page_variables.active_tab_2-1].season_number}}E@{{series.episodes[page_variables.active_tab_2-1].episode_number>9?series.episodes[page_variables.active_tab_2-1].episode_number:'0'+series.episodes[page_variables.active_tab_2-1].episode_number}} • @{{series.episodes[page_variables.active_tab_2-1].name}}</p>
            <div class="pt-2" ng-show="series.episodes[page_variables.active_tab_2-1].overview.length > 0"><p>@{{series.episodes[page_variables.active_tab_2-1].overview}}</p></div>
            <div class="pt-2" ng-show="series.episodes[page_variables.active_tab_2-1].overview.length == 0"><p>{{ __('general.no_overview_found') }}</p></div>
            <div ng-show="series.episodes[page_variables.active_tab_2-1].air_date.length>0">
                <div class="h6 pt-1"><span>{{ ucwords(__('general.air_date')) }}</span></div>
                <p><span class="d-inline">@{{series.episodes[page_variables.active_tab_2-1].air_date}}</p>
            </div>
        </div>
    </div>
    @if(Auth::check())
    <div class="col-12 col-lg-5" ng-show="page_variables.active_tab_1!=-1 && page_variables.active_tab_2!=-1">
        <img src="{{config('constants.image.cover')[$image_quality]}}@{{series.episodes[page_variables.active_tab_2-1].still_path}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid" alt="Responsive image">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto">
                <div class="d-flex flex-row justify-content-between text-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban text-nowrap" ng-class="{'text-primary':user_movie_record.last_seen_season==page_variables.active_tab_1 && user_movie_record.last_seen_episode==page_variables.active_tab_2}" ng-click="toggle_last_Seen()"><div><span><i class="fas fa-check"></i></span></div>{{ __('general.last_seen_episode') }}</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<!--Poster Plot Details Section-->


<!--Cast Section-->
<div class="container-fluid px-0 mt-5" id="cast" ng-show="series.credits.cast.length > 0" ng-hide="is_waiting">
    <div class="px-3 px-md-0">
        <div class="h5">{{ __('general.actors') }}
        @if(Auth::check())
        @if(Auth::User()->show_crew)
        & {{ __('general.crew') }}
        @endif
        @endif
        </div>
    </div>
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
        <div ng-show="series.credits.cast.length > 6">
            <div class="d-flex flex-wrap">
                <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.credits.cast | limitTo:100:6">
                    <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                        <a href="/person/@{{person.id}}" target={{$target}}>
                            <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                            <div class="card-block text-center">
                                <h6 class="card-title px-1 pt-1 text-dark" ng-show="person.name.length > 0">@{{person.name}}</h6>
                            </div>
                        </a>
                        <div class="card-title px-1 text-muted text-center mb-0"><small ng-show="person.character.length > 0">@{{person.character}}</small></div>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::check())
            @if(Auth::User()->show_crew)
        <div class="px-3 px-md-0 mt-5" ng-show="series.credits.crew.length > 0"><div class="h5">{{ __('general.crew') }}</div></div>
        <div ng-show="series.credits.crew.length > 0">
            <div class="d-flex flex-wrap">
                <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.credits.crew">
                    <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                        <a href="/person/@{{person.id}}" target={{$target}}>
                            <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                            <div class="card-block text-center">
                                <h6 class="card-title px-1 pt-1 text-dark" ng-show="person.name.length > 0">@{{person.name}}</h6>
                            </div>
                        </a>
                        <div class="card-title px-1 text-muted text-center mb-0"><small ng-show="person.job.length > 0">@{{person.job}}</small></div>
                    </div>
                </div>
            </div>
        </div>
            @endif
        @endif
    </div>
    @if(Auth::check())
        @if(Auth::User()->show_crew)
    <div ng-show="series.credits.cast.length > 6 || series.credits.crew.length > 0">
        @else
    <div ng-show="series.credits.cast.length > 6">
        @endif
    @else
    <div ng-show="series.credits.cast.length > 6">
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
<div class="container-fluid px-0 mt-5" id="guest_stars" ng-show="series.episodes[page_variables.active_tab_2-1].guest_stars.length > 0 && page_variables.active_tab_1 != -1 && is_waiting!=true">
    <div class="px-3 px-md-0"><div class="h5">{{ __('general.guest_stars') }}</div></div>
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
        <div ng-show="series.episodes[page_variables.active_tab_2-1].guest_stars.length > 6">
            <div class="d-flex flex-wrap">
                <div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in series.episodes[page_variables.active_tab_2-1].guest_stars | limitTo:100:6">
                    <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                        <a href="/person/@{{person.id}}" target={{$target}}>
                            <img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
                            <div class="card-block text-center">
                                <h6 class="card-title px-1 pt-1 text-dark" ng-show="person.name.length > 0">@{{person.name}}</h6>
                            </div>
                        </a>
                        <div class="card-title px-1 text-muted text-center mb-0"><small ng-show="person.character.length > 0">@{{person.character}}</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center pt-1" ng-hide="iscast || !(series.episodes[page_variables.active_tab_2-1].guest_stars.length>6)">
        <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast = true;" data-toggle="collapse" data-target="#collapseGuestStars"><small>{{ __('general.show_all') }}</small></button>
    </div>
    <div class="text-center pt-1" ng-show="iscast">
        <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast = false;" data-toggle="collapse" data-target="#collapseGuestStars"><i class="fa fa-angle-up"></i></button>
    </div>
</div>
<!--Cast Section-->

<div ng-hide="is_waiting"> 
@include('layout.reviews')
</div>

<!--People Who Liked Also Liked Section-->
<div class="container-fluid px-0 mt-5" id="pwhlal" ng-show="similar_movies.length > 0" ng-hide="is_waiting || similar_movies.length==0">
    <div class="dropdown d-inline">
        <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle px-3 px-md-0 border-0 background-inherit nowrap" type="button" id="peopleWhoLikedAlsoLikedDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="h5" ng-show="page_variables.active_tab_3==0">{{ __('general.people_who_liked_this_also_liked') }}</span>
            <span class="h5" ng-show="page_variables.active_tab_3!=0">{{ __('general.similar_series') }}</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="peopleWhoLikedAlsoLikedDropdownButton">
            <button class="dropdown-item" ng-click="page_variables.active_tab_3='0';set_recommendations();" ng-show="page_variables.has_recommendation">{{ __('general.people_who_liked_this_also_liked') }}</button>
            <button class="dropdown-item" ng-click="page_variables.active_tab_3='1';set_recommendations();" ng-show="page_variables.has_similar">{{ __('general.similar_series') }}</button>
        </div>
    </div>
    <span class="text-muted px-3 px-md-0 scrollmenu"><small>{{ __('general.sorted_by_relevance') }}</small></span>
    @include('layout.moviecard_6', ['suffix' => ''])
</div>
<!--People Who Liked Also Liked Section-->


@include('layout.this_ratemodal')
@include('layout.share_modal')
@endsection