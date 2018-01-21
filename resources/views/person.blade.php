@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_person')

@section('body')
<div class="position-relative mt-md-4">
	<img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{cover}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
	<div class="coveroverlayersmall d-md-none">
		<div class="d-flex flex-column align-items-center">
			<div class="d-flex flex-column">
				<div class="d-flex flex-row align-items-center">
					<img ng-src="{{config('constants.image.thumb_nail')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicsmall" alt="Responsive image">
					<h5><span class="badge badge-light ml-2 yeswrap text-left">{{config('constants.gabar')}}@{{person.name}} @{{age}} - {{ __('general.hismovies') }}</span></h5>
				</div>
			</div>
		</div>
	</div>
	<div class="coveroverlayermedium d-none d-md-inline">
		<div class="d-flex flex-column">
			<div class="d-flex flex-row align-items-center">
				<img ng-src="{{config('constants.image.thumb_nail')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicmedium" alt="Responsive image">
				<h5><span class="badge badge-light ml-2 yeswrap text-left">@{{person.name}} @{{age}} - {{ __('general.hismovies') }}</span></h5>
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
