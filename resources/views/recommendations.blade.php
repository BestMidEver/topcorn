@extends('layout.app')

@include('head.head_recommendations')

@section('body')
<div class="col mt-1 mb-2 mt-md-4">
	<h5 class="d-inline align-middle my-2">{{ __('navbar.recommendations') }}</h5>
	<button class="btn btn-warning btn-sm text-white ml-3 my-2" type="button" disabled>{{ Auth::user()->name }}</button>
	<button class="btn btn-warning btn-sm text-white mx-1 my-2" type="button" ng-repeat="user in party_members" ng-click="remove_from_party(user.user_id);">@{{user.name}} <i class="fa fa-times"></i></button>
	<button class="btn btn-outline-warning btn-sm my-2" type="button" data-toggle="collapse" data-target="#collapseAdd" ng-click="setFocus('input_user')"><i class="fas fa-user-plus"></i> {{ __('general.add_person') }}</button>
</div>

<div class="collapse container-fluid background-lightgrey" id="collapseAdd">
	<div class="row pt-3">
		<div class="col"></div>
		<div class="input-group input-group-lg col-12 col-xl-8">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
			</div>
			<input type="text" id="input_user" class="form-control" placeholder="{{ __('general.search_user') }}" aria-describedby="basic-addon1" ng-model="search_text" ng-change="search_users()" ng-model-options="{debounce: 750}">
		</div>
		<div class="col"></div>
	</div>
	<div class="py-3">
		<span class="h6 text-muted d-block" ng-hide="is_search">{{ __('general.previous_parties') }}</span>
		<span class="h6 text-muted d-block" ng-show="is_search">{{ __('general.search_results') }}</span>
		<div class="p-5" ng-show="users.length==0">
			<div class="text-muted text-center">{{ __('general.no_result') }}</div>
		</div>
		<div class="d-flex flex-wrap">
			<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-2 px-1" ng-repeat="user in users">
				<div class="card moviecard h-100 d-flex flex-column justify-content-between">
					<a ng-href="/profile/@{{user.user_id}}" target={{$target}}>
						<img class="card-img-top" ng-src="@{{(user.profile_path == null || user.profile_path == '') && user.facebook_profile_path || constants_image_thumb_nail + user.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
						<div class="card-block">
							<h6 class="card-title px-1 pt-1 text-muted text-center">@{{user.name}}</h6>
						</div>
					</a>
					<div class="card-footer p-0">
						<div class="row no-gutters">
							<div class="col">
								<button type="button" class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-disabled="user.user_id == user_id" ng-click="add_to_party(user)"><i class="fa fa-plus"></i> {{ __('general.add') }}</button>
							</div>
							<div class="col" ng-hide="is_search">
								<button type="button" class="btn btn-outline-secondary btn-sm btn-block addban border-0" ng-click="remove_from_history(user.user_id)"><i class="far fa-trash-alt"></i> {{ __('general.remove') }}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('layout.pagination', ['suffix' => '_search'])
	<div class="text-center pb-1">
		<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" data-toggle="collapse" data-target="#collapseAdd" ng-click="reset_add_person_input()"><i class="fa fa-angle-up"></i></button>
	</div>
</div>

<div class="container-fluid mt-3 pb-1" id="filter">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='top_rated'}" ng-click="active_tab='top_rated';get_first_page_data()">{{ __('general.top_rated') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='popular'}" ng-click="active_tab='popular';get_first_page_data()">{{ __('general.most_populer') }}</button>
		</li>
		<li class="nav-item mb-2">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='pemosu'}" ng-click="active_tab='pemosu';get_first_page_data()">{{ __('general.according_to_my_taste') }}</button>
		</li>
		<li class="nav-item ml-3 pb-2">
			<button class="nav-link btn btn-outline-secondary btn-sm" ng-click="drawslider();scroll_to_filter()" type="button" data-toggle="collapse" data-target="#collapseFilter"><i class="fa fa-filter"></i> {{ __('general.filter') }}</button>
		</li>
	</ul>
</div>

<div class="collapse container-fluid background-lightgrey" id="collapseFilter">
	@include('layout.recommendations_languages')
	@include('layout.recommendations_genres')
	<div class="mt-3 pb-3">
		<p class="h6 text-muted">YIL</p>
		<rzslider class="" rz-slider-model="slider.minValue"
		rz-slider-high="slider.maxValue"
		rz-slider-options="slider.options"></rzslider>
	</div>
	<div class="mt-3 pb-3">
		<p class="h6 text-muted">SIRALA</p>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input class="form-check-input" type="radio" name="inlineRadioOptions" ng-model="sort_by" value="point"> Eşleşme Puanına Göre
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input class="form-check-input" type="radio" name="inlineRadioOptions" ng-model="sort_by" value="percent"> Eşleşme Yüzdesine Göre
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input class="form-check-input" type="radio" name="inlineRadioOptions" ng-model="sort_by" value="top_rated"> Oyuna Göre
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input class="form-check-input" type="radio" name="inlineRadioOptions" ng-model="sort_by" value="popularity"> Popülerliğine Göre
			</label>
		</div>
	</div>
	<div class="text-center pb-1">
		<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" data-toggle="collapse" data-target="#collapseFilter"><i class="fa fa-angle-up" ng-click="scroll_to_filter()"></i></button>
	</div>
</div>

<div id="scroll_top_point">
	<div class="p-5" ng-show="movies.length==0">
		<div class="text-muted text-center"><span ng-if="!is_waiting">{{ __('general.no_result') }}</span><span ng-if="is_waiting">Aranıyor...</span></div>
	</div>
	@include('layout.moviecard')
</div>

@include('layout.pagination', ['suffix' => ''])

@endsection