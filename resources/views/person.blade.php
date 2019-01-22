@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_person')

@section('body')
<div class="position-relative mt-md-4">
	<img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{cover}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
	<div class="coveroverlayersmall-profile d-md-none">
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
		<a class="btn btn-link mb-2 text-light btn-sm" ng-href="{{config('constants.facebook.link')}}@{{person.external_ids.facebook_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}" ng-if="person.external_ids.facebook_id.length>0"><i class="fab fa-facebook-square"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" ng-href="{{config('constants.instagram.link')}}@{{person.external_ids.instagram_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}" ng-if="person.external_ids.instagram_id.length>0"><i class="fab fa-instagram"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" ng-href="{{config('constants.twitter.link')}}@{{person.external_ids.twitter_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}" ng-if="person.external_ids.twitter_id.length>0"><i class="fab fa-twitter-square"></i></a>
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
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab_0=='images'}" ng-click="active_tab_0='images';switch_tab()">Images</button>
		</li>
	</ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu my-3 d-md-none tab2">
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab_0=='movies'}" ng-click="active_tab_0='movies';switch_tab()">Movies</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab_0=='series'}" ng-click="active_tab_0='series';switch_tab()">Series</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab_0=='images'}" ng-click="active_tab_0='series';switch_tab()">Images</button>
</div>
<!-- Tabs Button Mobile -->




<div class="container-fluid" ng-if="active_tab_0 != 'images'">
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
			<i class="fa fa-filter"></i> @{{cast_or_crew}}
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

<div ng-if="active_tab_0 == 'images'" id="scroll_top_point">
	<div class="container-fluid">
		<div class="dropdown d-inline" ng-init="page_variables.image_tab='profile'">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-filter"></i> <span ng-if="page_variables.image_tab=='profile'">Profile</span><span ng-if="page_variables.image_tab=='tagged'">Tagged</span>
			</button>
			<span class="text-muted pl-2" ng-if="page_variables.image_tab=='profile'"><small>@{{profile_images.length}} <span ng-show="profile_images.length < 2">image</span><span ng-show="profile_images.length > 1">images</span></small></span>
			<span class="text-muted pl-2" ng-if="page_variables.image_tab!='profile'"><small>@{{tagged_images.total_results}} <span ng-show="tagged_images.total_results < 2">image</span><span ng-show="tagged_images.total_results > 1">images</span></small></span>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<button class="dropdown-item" ng-click="page_variables.image_tab='profile'">Profile</button>
				<button class="dropdown-item" ng-click="page_variables.image_tab='tagged'">Tagged</button>
			</div>
		</div>
	</div>

	<div class="card-group no-gutters" ng-if="page_variables.image_tab=='profile'">
		<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="image in profile_images">
			<div class="card moviecard h-100 d-flex flex-column justify-content-between mx-2">
				<a ng-click="image_full_screen(image)">
					<div class="position-relative text-center min-height-200">
						<img class="card-img-top darken-cover" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{image.file_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="card-columns mt-4" ng-if="page_variables.image_tab=='tagged'">
		<div class="card" ng-repeat="image in tagged_images.results">
			<img class="card-img-top" ng-src="{{config('constants.image.cover')[$image_quality]}}@{{image.file_path}}" alt="Card image cap" ng-click="image_full_screen(image)">
			<div class="card-block">
				<a ng-href="/@{{image.media_type=='movie'?'movie':'series'}}/@{{image.media.id}}" target={{$target}}>
					<h6 class="card-title px-1 py-1 my-0 text-dark text-left">@{{image.media_type=='movie'?image.media.title:image.media.name}} <small class="text-muted d-block pt-1" ng-if="image.media_type=='movie'"><em>(@{{image.media.release_date.substring(0, 4)}})</em></small><small class="text-muted d-block pt-1" ng-if="image.media_type!='movie'"><em>(@{{image.media.first_air_date.substring(0, 4)}})</em></small></h6>
				</a>
			</div>
		</div>
	</div>

	<div ng-if="page_variables.image_tab!='profile'">
		@include('layout.pagination', ['suffix' => ''])
	</div>
</div>
<div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="image_modal">
	<div class="modal-dialog modal-lg modal-dialog-centered mh-100 mw-100" role="document">
		<img class="mh-100 mw-100" ng-src="{{config('constants.image.original')}}@{{page_variables.current_image_poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">
	</div>
</div>
<!--<div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="image_modal">
	<div class="modal-dialog modal-lg modal-dialog-centered full-screen-modal" role="document">
		<div class="modal-content">
			<div class="card">
				<img class="card-img" ng-src="{{config('constants.image.original')}}@{{page_variables.current_image_poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">
				<div class="card-img-overlay p-2">
					<div class="text-center h-100 d-flex flex-column justify-content-between">
						<div class="d-flex flex-row justify-content-between">
							<div class="faderdiv">
							</div>
							<div class="faderdiv">
								<div class="h4 mr-3"><a ng-href="/" target={{$target}}><span class="badge btn-verydark yeswrap text-white">@{{modalmovie.title.length>0?modalmovie.title:modalmovie.name}} <small class="text-muted d-block pt-1" ng-if="modalmovie.release_date.length > 0"><em>(@{{modalmovie.release_date.substring(0, 4)}})</em></small><small class="text-muted d-block pt-1" ng-if="modalmovie.first_air_date.length > 0"><em>(@{{modalmovie.first_air_date.substring(0, 4)}})</em></small></span></a></div>
							</div>
							<div class="faderdiv">
								<button type="button" class="btn btn-verydark btn-lg float-right border-circle text-white" data-dismiss="modal" data-backdrop="false" aria-label="Close">
									<span><i class="fa fa-times"></i></span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<img class="d-none" ng-src="{{config('constants.image.original')}}@{{page_variables.previous_image.poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">
<img class="d-none" ng-src="{{config('constants.image.original')}}@{{page_variables.next_image.poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">-->
@endsection
