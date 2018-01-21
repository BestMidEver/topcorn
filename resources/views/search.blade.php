@extends('layout.app')

@include('head.head_search')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('general.search') }}</h5>

<div class="container-fluid mt-3">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='movie'}" ng-click="reset_tab();active_tab='movie';setFocus('input_movie')">{{ __('general.movie') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='person'}" ng-click="reset_tab();active_tab='person';setFocus('input_person')">{{ __('general.person') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='user'}" ng-click="reset_tab();active_tab='user';setFocus('input_user')">{{ __('general.user') }}</button>
		</li>
	</ul>
</div>

<div class="container-fluid mt-3">
	<div class="row">
		<div class="col"></div>
		<div class="input-group input-group-lg col-12 col-xl-8">
			<span class="input-group-addon" id="basic-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
			<input type="text" id="input_movie" class="form-control" ng-show="active_tab=='movie'" placeholder="{{ __('general.search_movie') }}" aria-describedby="basic-addon1" ng-model="model.movie" ng-change="get_page_data()" ng-model-options="{debounce: 750}" autofocus>
			<input type="text" id="input_person" class="form-control" ng-show="active_tab=='person'" placeholder="{{ __('general.search_person') }}" aria-describedby="basic-addon1" ng-model="model.person" ng-change="get_page_data()" ng-model-options="{debounce: 750}">
			<input type="text" id="input_user" class="form-control" ng-show="active_tab=='user'" placeholder="{{ __('general.search_user') }}" aria-describedby="basic-addon1" ng-model="model.user" ng-change="get_page_data()" ng-model-options="{debounce: 750}">
		</div>
		<div class="col"></div>
	</div>
</div>

<div id="scroll_top_point">
	<div class="p-5" ng-hide="movies.length>0 || people.length>0 || users.length>0 || (movies==null && people==null && users==null)">
		<div class="text-muted text-center">{{ __('general.no_result') }}</div>
	</div>

	<div ng-show="active_tab=='movie'">
	@include('layout.moviecard')
	</div>

	<div ng-show="active_tab=='person'">
	@include('layout.personcard')
	</div>

	<div class="d-flex flex-wrap" ng-show="active_tab=='user'">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-2 px-1" ng-repeat="user in users">
			<div class="card moviecard h-100 d-flex flex-column justify-content-between">
				<a ng-href="/profile/@{{ user.user_id }}">
					<img class="card-img-top" ng-src="@{{user.profile_path == '' && user.facebook_profile_path || constants_image_thumb_nail + user.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					<div class="card-block">
						<h6 class="card-title px-1 pt-1 text-muted text-center">@{{user.name}}</h6>
					</div>
				</a>
				<div class="card-footer p-0">
					<div class="row no-gutters">
						<div class="col">
							<a class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'disabled':user.user_id == user_id}" ng-href="/recommendations/@{{user.user_id}}"><i class="fa fa-plus" aria-hidden="true" disabled></i> {{ __('general.watch_together') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('layout.pagination', ['suffix' => ''])

@endsection