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
					<h5><a ng-href="http://www.google.com/search?q=@{{person.name}}" class="text-light" target="_blank"><span class="yeswrap text-left">{{config('constants.gabar')}}@{{person.name}} <span ng-if="person.birthday">(<i class="fas fa-birthday-cake"></i> @{{age}})</span> - {{ __('general.hismovies') }}</span></a></h5>
				</div>
				<div class="d-flex flex-row align-items-center text-light ml-2" ng-if="person.place_of_birth.length">
					<i class="fas fa-birthday-cake"></i><div class="d-inline pl-1" >@{{person.place_of_birth}}</div>
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
						<h5><a ng-href="http://www.google.com/search?q=@{{person.name}}" class="text-light" target="_blank"><span class="yeswrap text-left">{{config('constants.gabar')}}@{{person.name}} <span ng-if="person.birthday">(<i class="fas fa-birthday-cake"></i> @{{age}})</span> - {{ __('general.hismovies') }}</span></a></h5>
					</div>
					<div class="d-flex flex-row align-items-center text-light ml-2" ng-if="person.place_of_birth.length">
						<i class="fas fa-birthday-cake"></i><div class="d-inline pl-1" >@{{person.place_of_birth}}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid mt-3 pb-3">
	<ul class="nav justify-content-md-center tab1" ng-init=active_tab='vote_count'>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='vote_count'}" ng-click="active_tab='vote_count';filter('vote_count')">{{ __('general.most_rated') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='vote_average'}" ng-click="active_tab='vote_average';filter('vote_average')">{{ __('general.top_rated') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='release_date'}" ng-click="active_tab='release_date';filter('release_date')">{{ __('general.newest') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='title'}" ng-click="active_tab='title';filter('title')">{{ __('general.a_z') }}</button>
		</li>
	</ul>
</div>

<div class="container-fluid">
	<div class="dropdown" ng-init="cast_or_crew='{{ __('general.all') }}'">
		<button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
