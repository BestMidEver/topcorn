@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_movie')

@section('body')
<!-- Topcorn commercials -->
<div id="carouselExampleSlidesOnly" class="carousel slide mt-3" data-ride="carousel" data-interval="15000">
  <div class="carousel-inner bg-secondary h4 text-center text-white" style="height: 100px">
    <div class="carousel-item active h-100">
		<div class="d-flex justify-content-center align-items-center h-100">
			<div>
				If you enjoy using topcorn, please consider supporting us <a class="btn btn-link btn-sm fa40" style="color:#ff424d" href="{{config('constants.patreon.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('navbar.patreon') }}"><i class="fab fa-patreon"></i></a>
			</div>
		</div>
    </div>
    <div class="carousel-item h-100">
		<div class="d-flex justify-content-center align-items-center h-100">
			<div>
				Have you tried our Android app? <a class="btn btn-link btn-sm fa40" style="color:#a4c639" href="{{config('constants.android.our_link')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_android') }}"><i class="fab fa-android"></i></a>
			</div>
		</div>
    </div>
  </div>
</div>
<!-- Topcorn commercials -->
<!--Trailer Section-->
<div class="mt-md-4" ng-cloak>
	<div class="position-relative">
		<div id="accordion">
			<div>
				<div id="collapseCover" class="collapse show" data-parent="#accordion">
					<img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{movie.backdrop_path}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid trailercover" alt="Responsive image">
					<div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
						<div class="d-flex flex-row no-gutters">
							<div class="col pt-2 pl-2">
								<span class="text-white h6 lead lead-small">@{{movie.tagline}}</span>
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
						<div class="d-flex flex-row justify-content-center" ng-show="movie.videos.results.length > 0">
							<button class="btn btn-link text-white btn-lg" ng-click="isfragman=true;scroll_to_top()" data-toggle="collapse" data-target="#collapseFragman" aria-expanded="false" aria-controls="collapseFragman"><i class="far fa-play-circle mr-2"></i><small>{{ __('general.trailer') }}</small></button>
						</div>
						<div class="d-flex flex-row justify-content-end p-2 text-right">
							<div ng-show="{{$vote_average}} > 0">
								<div><span class="text-warning display-4 d-none d-md-inline">{{$vote_average}}</span><span class="text-warning h5 d-md-none">{{$vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
								<div><span class="text-white"><small>{{$vote_count}}</small></span><span class="text-white"> <small><span ng-show="{{$vote_count}} == 1">{{ __('general.person_time') }}</span><span ng-show="{{$vote_count}} > 1">{{ __('general.person_times') }}</span></small></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div id="collapseFragman" class="collapse" data-parent="#accordion" ng-show="movie.videos.results.length > 0">
					<div class="d-flex flex-row background-black no-gutters pl-2 pt-2 pb-3">
						<div class="col">
							<div class="h-100 d-flex flex-column justify-content-center pl-2">
								<span class="text-white h6 lead lead-small">@{{movie.tagline}}</span>
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
								<div ng-show="movie.videos.results.length > 1">
									<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == 0" ng-class="{'btn-trailer':current_trailer==0}" ng-click="previous_trailer();"><i class="fa fa-step-backward"></i></button>
									<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == movie.videos.results.length-1" ng-class="{'btn-trailer':current_trailer==movie.videos.results.length-1}" ng-click="next_trailer();"><i class="fa fa-step-forward"></i></button>
                                    <div class="dropdown dnone d-md-inline" ng-show="movie.videos.results.length>1">
                                        <button class="btn btn-outline-secondary border-0 btn-lg hover-white dropdown-toggle" type="button" id="dropdownchoosetrailer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownchoosetrailer">
                                            <a class="dropdown-item" ng-repeat="trailer in movie.videos.results" ng-click="change_trailer($index)">@{{trailer.name}}</a>
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
							<div ng-show="{{$vote_average}} > 0">
								<div><span class="text-warning h4 d-none d-md-inline">{{$vote_average}}</span><span class="text-warning h5 d-md-none">{{$vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
								<div><span class="text-white"><small>{{$vote_count}}</small></span><span class="text-white"> <small><span ng-show="{{$vote_count}} == 1">{{ __('general.person_time') }}</span><span ng-show="{{$vote_count}} > 1">{{ __('general.person_times') }}</span></small></span></div>
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
<div class="d-flex flex-wrap justify-content-between" ng-cloak>
	<div>
		<div class="d-flex flex-column">
			<div class="px-3 px-md-0">
				<a class="text-dark" ng-href="http://www.google.com/search?q=@{{movie.title+' '+movie.release_date.substring(0, 4)}}" target="_blank">
					<h1 class="h4 pb-2 pt-3"
					@if(Auth::check())
						@if(Auth::User()->tt_movie < 50)
		            data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="google"
		            	@endif
		            @endif
					>@{{movie.title}}</h1>
				</a>
			</div>
		</div>
	</div>
	<div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto">
		<div class="d-flex flex-row justify-content-between text-center">
			@if(Auth::check())
			<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addlater" ng-class="{'text-warning':user_movie_record.later_id!=null}" ng-click="this_later()"><div><span ng-show="user_movie_record.later_id!=null"><i class="fas fa-clock"></i></span><span ng-show="user_movie_record.later_id==null"><i class="far fa-clock"></i></span></div><span class="scrollmenu">{{ __('general.watch_later') }}</span></button>
			<button type="button" class="btn btn-sm btn-block border-0 mt-0 px-lg-4 addseen" ng-class="rate_class(user_movie_record.rate_code)" ng-click="this_votemodal()"><div><span ng-show="!user_movie_record.rate_code>0"><i class="far fa-star"></i></span><span ng-show="user_movie_record.rate_code>0"><i class="fas fa-check"></i></span></div>{{ __('general.seen') }}</button>
			<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-class="{'text-danger':user_movie_record.ban_id!=null}" ng-click="this_ban()"><div><i class="fas fa-ban"></i></div>{{ __('general.ban') }}</button>
			<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-click="open_share_modal()"><div><i class="fas fa-share"></i></div>{{ __('general.share') }}</button>
			@endif
			@if(Auth::guest())
			<a ng-href="{{config('constants.facebook.share_website')}}/movie/{{$id}}/{{App::getlocale()}}" target="_blank" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addfacebook"><div><i class="fas fa-share"></i></div>{{ __('general.share') }}</a>
            @endif
		</div>
	</div>
</div>
<!--Under Trailer Section-->

<!-- @yield('amazon_affiliate') -->

<!--Poster Plot Details Section-->
<div class="row no-gutters mt-3 mt-md-5" ng-cloak>
	<div class="col-12 col-md-3 col-lg-3">
		<img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top d-none d-md-inline" alt="Responsive image">
	</div>
	<div class="col-12 col-md-9 col-lg-6">
		<div class="container-fluid">
			<p class="h6 pt-3 pt-md-0"><span data-toggle="tooltip" data-placement="top" data-original-title="@{{movie.release_date}}" ng-show="movie.release_date.length>0">@{{movie.release_date.substring(0, 4)}}</span> <span class="text-muted" ng-show="movie.genres.length > 0 && movie.release_date.length>0">•</span> <span ng-repeat="genre in movie.genres"><span ng-show="$index!=0">, </span>@{{genre.name}}</span></p>
			<div class="pt-2" ng-show="movie.overview.length > 0 && movie.overview != 'No overview found.'"><p>@{{movie.overview}}</p></div>
			<div ng-show="directors.length > 0">
				<div class="h6 pt-1"><span ng-show="directors.length == 1">{{ __('general.director') }}</span><span ng-show="directors.length > 1">{{ __('general.directors') }}</span></div>
				<p><span class="d-inline" ng-repeat="director in directors"><span ng-show="$index!=0">, </span><a href="/person/@{{director.id}}" target={{$target}} class="text-dark">@{{director.name}}</a></span></p>
			</div>
			<div ng-show="writers.length > 0">
				<div class="h6 pt-1"><span ng-show="writers.length == 1">{{ __('general.writer') }}</span><span ng-show="writers.length > 1">{{ __('general.writers') }}</span></div>
				<p><span class="d-inline" ng-repeat="writer in writers"><span ng-show="$index!=0">, </span><a href="/person/@{{writer.id}}" target={{$target}} class="text-dark nowrap">@{{writer.name}}</a> @{{'(' + writer.job +')'}}</span></p>
			</div>
		</div>
	</div>
	<div class="col-3 d-none d-md-inline d-lg-none"></div>
	<div class="col-9 col-lg-3">
		<div class="container-fluid">
			<div class="h5 d-none d-lg-inline">{{ __('general.movie_details') }}</div>
			<div ng-show="movie.original_title.length > 0">
				<div class="h6 pt-2">{{ __('general.original_title') }}</div>
				<a class="text-dark" ng-href="http://www.google.com/search?q=@{{movie.original_title+' '+movie.release_date.substring(0, 4)}}" target="_blank"><p>@{{movie.original_title}}</p></a>
			</div>
			<div ng-show="secondary_title.length > 0">
				<div class="h6 pt-1">@{{secondary_language}} {{ __('general.its_title') }}</div>
				<a class="text-dark" ng-href="http://www.google.com/search?q=@{{secondary_title+' '+movie.release_date.substring(0, 4)}}" target="_blank"><p>@{{secondary_title}}</p></a>
			</div>
			<div ng-show="movie.original_language.length > 0">
				<div class="h6 pt-1">{{ __('general.original_language') }}</div>
				<p>@{{movie.original_language}}</p>
			</div>
			<div ng-show="movie.production_countries.length > 0">
				<div class="h6 pt-1"><span ng-show="movie.production_countries.length == 1">{{ __('general.producer_country') }}</span><span ng-show="movie.production_countries.length > 1">{{ __('general.producer_countries') }}</span></span></div>
				<p><span ng-repeat="country in movie.production_countries"><span ng-show="$index!=0">, </span>@{{country.name}}</span></p>
			</div>
			<div ng-show="fancyruntime.hour > 0">
				<div class="h6 pt-1">{{ __('general.runtime') }}</div>
				<p>@{{movie.runtime}} {{ __('general.time_minutes') }} <small class="text-muted">(@{{fancyruntime.hour}}{{ __('general.h') }} @{{fancyruntime.minute}}{{ __('general.m') }})</small></p>
			</div>
			<div ng-show="movie.budget > 0 && movie.budget != 0">
				<div class="h6 pt-1">{{ __('general.budget') }}</div>
				<p>$@{{fancybudget}}</p>
			</div>
			<div ng-show="movie.revenue > 0 && movie.revenue != 0">
				<div class="h6 pt-1">{{ __('general.revenue') }}</div>
				<p>$@{{fancyrevenue}}</p>
			</div>
            <div ng-show="movie.external_ids.facebook_id.length>0 || movie.external_ids.instagram_id.length>0 || movie.external_ids.twitter_id.length>0">
                <div class="h6 pt-1">{{ __('general.links') }}</div>
                <p>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.facebook.link')}}@{{movie.external_ids.facebook_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}" ng-show="movie.external_ids.facebook_id.length>0"><i class="fab fa-facebook-square"></i></a>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.instagram.link')}}@{{movie.external_ids.instagram_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}" ng-show="movie.external_ids.instagram_id.length>0"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-link btn-sm fa40 text-muted px-0 mr-2" ng-href="{{config('constants.twitter.link')}}@{{movie.external_ids.twitter_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}" ng-show="movie.external_ids.twitter_id.length>0"><i class="fab fa-twitter-square"></i></a>
                </p>
            </div>
		</div>
	</div>
</div>
<!--Poster Plot Details Section-->




<!--Cast Section-->
<div ng-cloak
			@if(Auth::check())
				@if(Auth::User()->tt_movie < 50)
            data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="cast"
            	@endif
            @endif
			>
<div class="container-fluid px-0 mt-5" id="cast" ng-show="movie.credits.cast.length > 0">
	<div class="px-3 px-md-0">
		<div class="h5">
		{{ __('general.actors') }}
		@if(Auth::check())
        @if(Auth::User()->show_crew)
        & {{ __('general.crew') }}
        @endif
        @endif
		</div>
	</div>
	<div class="">
		<div class="d-flex flex-wrap">
			<div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in movie.credits.cast | limitTo:6">
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
		<div ng-show="movie.credits.cast.length > 6">
			<div class="d-flex flex-wrap">
				<div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in movie.credits.cast | limitTo:100:6">
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
		<div class="px-3 px-md-0 mt-5" ng-show="movie.credits.crew.length > 0"><div class="h5">{{ __('general.crew') }}</div></div>
		<div ng-show="movie.credits.crew.length > 0">
			<div class="d-flex flex-wrap">
				<div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in movie.credits.crew">
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
	<div ng-show="movie.credits.cast.length > 6 || movie.credits.crew.length > 0">
		@else
	<div ng-show="movie.credits.cast.length > 6">
		@endif
	@else
	<div ng-show="movie.credits.cast.length > 6">
	@endif
		<div class="text-center pt-1" ng-hide="iscast">
			<button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast = true;" data-toggle="collapse" data-target="#collapseCast"><small>{{ __('general.show_everyone') }}</small></button>
		</div>
		<div class="text-center pt-1" ng-show="iscast">
			<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast = false;" data-toggle="collapse" data-target="#collapseCast"><i class="fa fa-angle-up"></i></button>
		</div>
	</div>
</div>
</div>
<!--Cast Section-->

<!-- @yield('amazon_affiliate_2') -->
@include('layout.reviews')

<!--People Who Liked Also Liked Section-->
<div class="container-fluid px-0 mt-5" ng-hide="is_waiting || (similar_movies.length==0 && listes.length==0)" ng-cloak>
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
		    <div class="dropdown d-inline mr-2">
		        <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle px-3 px-md-0 border-0 background-inherit nowrap" type="button" id="peopleWhoLikedAlsoLikedDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		        <span class="h5" ng-show="page_variables.active_tab_3==3">@{{movie.belongs_to_collection.name}}</span>
		        <span class="h5" ng-show="page_variables.active_tab_3==0">{{ __('general.people_who_liked_this_also_liked') }}</span>
		        <span class="h5" ng-show="page_variables.active_tab_3==1">{{ __('general.similar_movies') }}</span>
		        <span class="h5" ng-show="page_variables.active_tab_3==2">{{ __('general.movie_lists_title') }}</span>
		        </button>
		        <div class="dropdown-menu" aria-labelledby="peopleWhoLikedAlsoLikedDropdownButton">
		            <button class="dropdown-item" ng-click="page_variables.active_tab_3=3;set_recommendations();" ng-show="movie.belongs_to_collection">@{{movie.belongs_to_collection.name}}</button>
		            <button class="dropdown-item" ng-click="page_variables.active_tab_3=0;set_recommendations();" ng-show="page_variables.has_recommendation">{{ __('general.people_who_liked_this_also_liked') }}</button>
		            <button class="dropdown-item" ng-click="page_variables.active_tab_3=1;set_recommendations();" ng-show="page_variables.has_similar">{{ __('general.similar_movies') }}</button>
		            <button class="dropdown-item" ng-click="page_variables.active_tab_3=2;" ng-show="listes.length>0">{{ __('general.movie_lists_title') }}</button>
		        </div>
		    </div>
		    <span class="text-muted scrollmenu px-3 px-md-0" ng-show="page_variables.active_tab_3!=2 && page_variables.active_tab_3!=3"><small>Sorted by relevance</small></span>
		</div>
		@if(Auth::check())
		<button href="/createlist/new" class="btn btn-outline-secondary addban border-0" ng-show="page_variables.active_tab_3==2" target="{{$target}}"><div><i class="fas fa-plus"></i></div> <span>{{ __('general.create_list') }}</span></button>
        @endif
	</div>
	<div ng-show="page_variables.active_tab_3!=2">
    @include('layout.moviecard_6', ['suffix' => ''])
	</div>
	<div class="p-5" ng-show="(page_variables.active_tab_3==2 && listes.length==0) || (page_variables.active_tab_3!=2 && !similar_movies.length>0)">
		<div class="text-muted text-center"><span>{{ __('general.no_result') }}</span></div>
	</div>
	<div class="card-group no-gutters" ng-show="page_variables.active_tab_3==2">
		@include('layout.listcard')
	</div>
</div>
<!--People Who Liked Also Liked Section-->


<!--<div class="container-fluid pt-5">
	<span class="h5 mb-0">{{ __('general.fb_comments') }}</span>
	<div class="fb-comments" data-href="https://topcorn.xyz/movie/{{$id_dash_title}}" data-width="100%" data-numposts="6" data-colorscheme="{{Auth::check()?(Auth::User()->theme==1?'dark':'light'):''}}"></div>
</div>-->

@include('layout.this_ratemodal')
@include('layout.share_modal')

@if(Auth::check())
	@if(Auth::User()->tt_movie < 50)
<div id="popover-content-share" class="d-none">
    <p>{{ __("tutorial.share") }}</p>
    <div class="text-right">
        <a class="btn btn-link d-inline text-muted" href="#cancel-movie-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-link d-inline" href="#tooltip-movie-search">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-google" class="d-none">
    <p>{{ __("tutorial.google") }}</p>
    <div class="text-right">
        <a class="btn btn-link d-inline text-muted" href="#cancel-movie-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-link d-inline" href="#tooltip-movie-cast">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-cast" class="d-none">
    <p>{{ __("tutorial.cast") }}</p>
    <div class="text-right">
        <a class="btn btn-link d-inline text-muted" href="#cancel-movie-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-link d-inline" href="#tooltip-movie-review">{{ __("tutorial.understood") }}</a>
    </div>
</div>
<div id="popover-content-review" class="d-none">
    <p>{{ __("tutorial.review") }}</p>
    <div class="text-right">
        <a class="btn btn-link d-inline text-muted" href="#cancel-movie-tooltips">{{ __("tutorial.dont_show_hints") }}</a>
        <a class="btn btn-link d-inline" href="#movie-tooltips-done">{{ __("tutorial.understood") }}</a>
    </div>
</div>
	@endif
@endif

@endsection