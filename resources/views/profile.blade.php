@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_profile')

@section('body')
<div class="position-relative mt-md-4">
	<img ng-src="{{config('constants.image.cover')[$image_quality]}}{{ $profile_cover_pic }}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
	<div class="coveroverlayersmall d-md-none">
		<div class="d-flex flex-column align-items-center">
			<div class="d-flex flex-column">
				<div class="d-flex flex-row align-items-center">
					<div class="d-flex flex-column">
						<img ng-src="{{ $profile_profile_pic }}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicsmall" alt="Responsive image">
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex flex-row align-items-center ml-2">
							<h5><span class="yeswrap text-left text-light">{{ $profile_user_name }}</span></h5>
						</div>
						<div class="d-flex flex-row align-items-center text-light ml-2">
							<i class="fas fa-check"></i><div class="d-inline pl-1" >{{ $profile_watched_movie_number }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="coveroverlayermedium d-none d-md-inline">
		<div class="d-flex flex-column">
			<div class="d-flex flex-row align-items-center">
				<div class="d-flex flex-column">
					<img ng-src="{{ $profile_profile_pic }}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicmedium" alt="Responsive image">
				</div>
				<div class="d-flex flex-column">
					<div class="d-flex flex-row align-items-center ml-2">
						<h5><span class="yeswrap text-left text-light">{{ $profile_user_name }}</span></h5>
					</div>
					<div class="d-flex flex-row align-items-center text-light ml-2">
						<div>
							<i class="fas fa-check"></i><div class="d-inline pl-1" >{{ $profile_watched_movie_number }}</div>
						</div>
						<div class="pl-3">
							<i class="fas fa-list"></i><div class="d-inline pl-1" >6</div>
						</div>
						<div class="pl-3">
							<i class="fas fa-heart"></i><div class="d-inline pl-1" >72</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@if(Auth::check())
	<div class="right-top">
		@if($profile_user_id == Auth::user()->id)
		<a class="btn btn-link mt-2 mr-2 text-light" href="/account"><i class="fa fa-cog" aria-hidden="true"></i><span class="d-none d-md-inline"> {{ __('navbar.account') }}</span></a>
		@else
		<a class="btn btn-link mt-2 mr-2 text-light" href="/recommendations/{{$profile_user_id}}"><i class="fa fa-plus" aria-hidden="true"></i><span class="d-none d-md-inline"> {{ __('general.watch_together') }}</span></a>
		@endif
	</div>
	@endif
	<div class="right-bottom pr-2 fa30">
		@if(0)
		<a class="btn btn-link mb-2 text-light btn-sm" href="#"><span class="h6">Personal Website</span></a>
		<a class="btn btn-link mb-2 text-light btn-sm" href="#"><i class="fab fa-instagram"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" href="#"><i class="fab fa-facebook-square"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" href="#"><i class="fab fa-linkedin"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" href="#"><i class="fab fa-twitter-square"></i></a>
		<a class="btn btn-link mb-2 text-light btn-sm" href="#"><i class="fab fa-youtube-square"></i></a>
		@endif
	</div>
</div>

<div class="container-fluid mt-3 pb-3">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab!='get_laters' && active_tab!='get_bans' && active_tab!='get_lists'}" ng-click="mod_title='{{ __('general.definitely_recommend') }}';active_tab='get_rateds/5';get_first_page_data()">{{ __('general.seen_movies') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_laters'}" ng-click="active_tab='get_laters';get_first_page_data();">{{ __('general.watch_later') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_bans'}" ng-click="active_tab='get_bans';get_first_page_data();">{{ __('general.banneds') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_lists'}" ng-click="active_tab='get_lists';get_page_data();">{{ __('general.lists') }}</button>
		</li>
	</ul>
</div>

<div class="container-fluid" ng-show="active_tab!='get_laters' && active_tab!='get_bans' && active_tab!='get_lists'">
	<div class="dropdown d-inline" ng-init="mod_title='{{ __('general.definitely_recommend') }}'">
		<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			@{{mod_title}}
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<button class="dropdown-item" ng-click="mod_title='{{ __('general.definitely_recommend') }}';active_tab='get_rateds/5';get_first_page_data();">{{ __('general.definitely_recommend') }}</button>
			<button class="dropdown-item" ng-click="mod_title='{{ __('general.recommend') }}';active_tab='get_rateds/4';get_first_page_data();">{{ __('general.recommend') }}</button>
			<button class="dropdown-item" ng-click="mod_title='{{ __('general.not_sure') }}';active_tab='get_rateds/3';get_first_page_data();">{{ __('general.not_sure') }}</button>
			<button class="dropdown-item" ng-click="mod_title='{{ __('general.dont_recommend') }}';active_tab='get_rateds/2';get_first_page_data();">{{ __('general.dont_recommend') }}</button>
			<button class="dropdown-item" ng-click="mod_title='{{ __('general.definitely_dont_recommend') }}';active_tab='get_rateds/1';get_first_page_data();">{{ __('general.definitely_dont_recommend') }}</button>
			<div class="dropdown-divider"></div>
			<button class="dropdown-item" ng-click="mod_title='{{ __('general.all') }}';active_tab='get_rateds/all';get_first_page_data();">{{ __('general.all') }}</button>
		</div>
	</div>
	<span class="text-muted pl-2"><small>@{{in}} <span ng-show="in < 2">{{ strtolower(__('general.movie')) }}</span><span ng-show="in > 1">{{ strtolower(__('general.movies')) }}</span></small></span>
</div>

<div id="scroll_top_point">
	<div class="p-5" ng-show="(active_tab != 'get_lists' && movies.length==0) || (active_tab == 'get_lists' && listes.length==0)">
		<div class="text-muted text-center">{{ __('general.no_result') }}</div>
	</div>
	@include('layout.moviecard')
	<div class="card-group no-gutters">
		@include('layout.listcard')
		@if($profile_user_id == Auth::user()->id)
		<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-if="active_tab=='get_lists'">
			<div class="h-100 d-flex flex-column justify-content-center mx-2">
				<div class="d-flex flex-row justify-content-center">
					<a href="/createlist/new" class="btn btn-verydark border-circle text-white btn-lg" data-toggle="tooltip" data-placement="top" title="{{ __('general.create_list') }}"><i class="fas fa-plus"></i></a>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
@include('layout.pagination', ['suffix' => ''])


@endsection
