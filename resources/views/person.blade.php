@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_person')

@section('body')
<div class="position-relative mt-md-4">
	<img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{cover}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
	<div class="coveroverlayersmall d-md-none">
		<div class="d-flex flex-column align-items-center">
			<div class="d-flex flex-column">
				<img ng-src="{{config('constants.image.thumb_nail')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicsmall" alt="Responsive image">
			</div>
			<div class="d-flex flex-column">
				<div class="d-flex flex-row align-items-center ml-2">
					<h5><a ng-href="http://www.google.com/search?q=@{{person.name}}" class="text-light" target="_blank"><span class="yeswrap text-left">{{config('constants.gabar')}}@{{person.name}} @{{age}} - {{ __('general.hismovies') }}</span></a></h5>
				</div>
				<div class="d-flex flex-row align-items-center text-light ml-2" ng-if="person.place_of_birth">
					<a ng-href="http://www.google.com/search?q=@{{person.place_of_birth}}" class="text-light" target="_blank"><i class="fas fa-map-marker"></i><div class="d-inline pl-1" >@{{person.place_of_birth}}</div></a>
				</div>
				<div class="d-flex flex-row align-items-center text-light ml-2" ng-if="person.deathday">
					<i class="fab fa-studiovinari"></i><div class="d-inline pl-1" >@{{person.deathday}}</div>
				</div>
			</div>
		</div>
	</div>
	<div class="coveroverlayermedium d-none d-md-inline">
		<div class="d-flex flex-column">
			<div class="d-flex flex-row align-items-center">
				<div class="d-flex flex-column">
					<img ng-src="{{config('constants.image.thumb_nail')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicmedium" alt="Responsive image">
				</div>
				<div class="d-flex flex-column">
					<div class="d-flex flex-row align-items-center ml-2">
						<h5><a ng-href="http://www.google.com/search?q=@{{person.name}}" class="text-light" target="_blank"><span class="yeswrap text-left">{{config('constants.gabar')}}@{{person.name}} @{{age}} - {{ __('general.hismovies') }}</span></a></h5>
					</div>
					<div class="d-flex flex-row align-items-center text-light ml-2" ng-if="person.place_of_birth">
						<a ng-href="http://www.google.com/search?q=@{{person.place_of_birth}}" class="text-light" target="_blank"><i class="fas fa-map-marker"></i><div class="d-inline pl-1" >@{{person.place_of_birth}}</div></a>
					</div>
					<div class="d-flex flex-row align-items-center text-light ml-2" ng-if="person.deathday">
						<i class="fab fa-studiovinari"></i><div class="d-inline pl-1" >@{{person.deathday}}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="right-bottom pr-2 fa30">
		<a class="btn btn-link mb-2 text-light btn-sm" href="{{config('constants.facebook.link').$facebook_link}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}"><i class="fab fa-facebook-square"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" href="{{config('constants.instagram.link').$instagram_link}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}"><i class="fab fa-instagram"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" href="{{config('constants.twitter.link').$twitter_link}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}"><i class="fab fa-twitter-square"></i></a>
	</div>
</div>




<!-- Tabs Button -->
<div class="container-fluid mt-3 pb-3 d-none d-md-inline">
	<ul class="nav justify-content-md-center tab1" ng-init="active_tab_0='movies'">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab_0=='movies'}" ng-click="active_tab_0='movies';switch_tab()">Movies</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab_0=='series'}" ng-click="active_tab_0='series';switch_tab()">Series</button>
		</li>
	</ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu my-3 d-md-none tab2">
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab_0=='movies'}" ng-click="active_tab_0='movies';switch_tab()">Movies</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab_0=='series'}" ng-click="active_tab_0='series';switch_tab()">Series</button>
</div>
<!-- Tabs Button Mobile -->




<div class="container-fluid">
	<div class="dropdown d-inline mr-2" ng-init="active_tab='vote_count'">
		<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-sort-amount-down"></i> <span ng-if="active_tab=='vote_count'">Most Popular</span><span ng-if="active_tab=='vote_average'">Top Rated</span><span ng-if="active_tab=='release_date'">Newest</span><span ng-if="active_tab=='title'">A -> Z</span>
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
			<button class="dropdown-item" ng-click="active_tab='vote_count';filter('vote_count')">Most Popular</button>
			<button class="dropdown-item" ng-click="active_tab='vote_average';filter('vote_average')">Top Rated</button>
			<button class="dropdown-item" ng-click="active_tab='release_date';filter('release_date')">Newest</button>
			<button class="dropdown-item" ng-click="active_tab='title';filter('title')">A -> Z</button>
		</div>
	</div>
	<div class="dropdown d-inline" ng-init="cast_or_crew='{{ __('general.all') }}'">
		<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			@{{cast_or_crew}}
		</button>
		<span class="text-muted pl-2"><small>@{{movies.length}} <span ng-show="movies.length < 2">{{ strtolower(__('general.movie')) }}</span><span ng-show="movies.length > 1">{{ strtolower(__('general.movies')) }}</span></small></span>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<button class="dropdown-item" ng-show="person.movie_credits.cast.length>0" ng-click="cast_or_crew='{{ __('general.acting') }}';filter('cast')">{{ __('general.acting') }}</button>
			<button class="dropdown-item" ng-repeat="job in jobs" ng-click="filter(job.department,job.job)">@{{job.job}}</button>
			<div class="dropdown-divider"></div>
			<button class="dropdown-item" ng-click="cast_or_crew='{{ __('general.all') }}';filter('all')">{{ __('general.all') }}</button>
		</div>
	</div>
</div>

@include('layout.moviecard')

@endsection
