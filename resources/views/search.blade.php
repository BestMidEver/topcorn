@extends('layout.app')

@include('head.head_search')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4" ng-cloak>{{ __('general.search') }}</h1>

<!-- @yield('amazon_affiliate') -->






<!-- Tabs Button -->
<div class="container-fluid mt-3 d-none d-md-inline" ng-cloak>
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='movie'}" ng-click="reset_tab();active_tab='movie';get_page_data();setFocus('input_movie')">{{ __('general.movie') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='series'}" ng-click="reset_tab();active_tab='series';get_page_data();setFocus('input_series')">{{ __('general.series') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='person'}" ng-click="reset_tab();active_tab='person';get_page_data();setFocus('input_person')">{{ __('general.person') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='user'}" ng-click="reset_tab();active_tab='user';get_page_data();setFocus('input_user')">{{ __('general.user') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='list'}" ng-click="reset_tab();active_tab='list';get_page_data();setFocus('input_list')">{{ __('general.list') }}</button>
		</li>
	</ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu my-3 tab2 d-md-none" ng-cloak>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='movie'}" ng-click="reset_tab();active_tab='movie';get_page_data();setFocus('input_movie')">{{ __('general.movie') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='series'}" ng-click="reset_tab();active_tab='series';get_page_data();setFocus('input_series')">Series</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='person'}" ng-click="reset_tab();active_tab='person';get_page_data();setFocus('input_person')">{{ __('general.person') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='user'}" ng-click="reset_tab();active_tab='user';get_page_data();setFocus('input_user')">{{ __('general.user') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='list'}" ng-click="reset_tab();active_tab='list';get_page_data();setFocus('input_list')">{{ __('general.list') }}</button>
</div>
<!-- Tabs Button Mobile -->





<div class="container-fluid mt-3" ng-cloak>
	<div class="row">
		<div class="col"></div>
		<div class="input-group input-group-lg col-12 col-xl-8">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
			</div>
			<input type="text" id="input_movie" class="form-control" ng-show="active_tab=='movie'" placeholder="{{ __('general.search_movie') }}" ng-model="generalinput" ng-change="reset_tab();get_page_data()" ng-model-options="{debounce: 750}" autofocus>
			<input type="text" id="input_series" class="form-control" ng-show="active_tab=='series'" placeholder="{{ __('general.search_series') }}" ng-model="generalinput" ng-change="reset_tab();get_page_data()" ng-model-options="{debounce: 750}" autofocus>
			<input type="text" id="input_person" class="form-control" ng-show="active_tab=='person'" placeholder="{{ __('general.search_person') }}" ng-model="generalinput" ng-change="reset_tab();get_page_data()" ng-model-options="{debounce: 750}">
			<input type="text" id="input_user" class="form-control" ng-show="active_tab=='user'" placeholder="{{ __('general.search_user') }}" ng-model="generalinput" ng-change="reset_tab();get_page_data()" ng-model-options="{debounce: 750}">
			<input type="text" id="input_list" class="form-control" ng-show="active_tab=='list'" placeholder="{{ __('general.search_list') }}" ng-model="generalinput" ng-change="reset_tab();get_page_data()" ng-model-options="{debounce: 750}">
		</div>
		<div class="col"></div>
	</div>
</div>




<!-- Recently visited -->
<div ng-if="isInputEmpty && active_tab !== 'list' && active_tab !== 'user'" class="mx-2 mt-4 row d-flex justify-content-between" ng-cloak>
	<div class="h6 my-auto">{{ __('general.recently_visited') }}</div>
	<button ng-if="!noHistory" class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration p-0" ng-click="clearHistory();">{{ __('general.clear_all') }}</button>
</div>
<!-- Recently visited -->





<div id="scroll_top_point" ng-cloak>
	<div class="p-5" ng-hide="(movies.length>0 || people.length>0 || users.length>0 || listes.length>0 || (movies==null && people==null && users==null && listes==null)) && !is_waiting">
		<div class="text-muted text-center" ng-if="!is_waiting">{{ __('general.no_result') }}</div><div class="text-muted text-center" ng-if="is_waiting">{{ __('general.searching') }}</div>
	</div>

	<div ng-show="active_tab=='movie' || active_tab=='series'">
	@include('layout.moviecard')
	</div>

	<div ng-show="active_tab=='person'">
	@include('layout.personcard')
	</div>

	<div class="d-flex flex-wrap" ng-show="active_tab=='user'">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in users">
			<div class="card moviecard h-100 d-flex flex-column justify-content-between">
				<a ng-href="/profile/@{{ user.user_id }}" target={{$target}}>
					<img class="card-img-top" ng-src="@{{user.profile_path == null || user.profile_path == '' ? user.facebook_profile_path : constants_image_thumb_nail + user.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
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

	<div class="card-group no-gutters">
		@include('layout.listcard')
	</div>
</div>

@include('layout.pagination', ['suffix' => ''])

@endsection