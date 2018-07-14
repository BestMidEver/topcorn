@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_recommendations')

@section('body')
<!-- H1 +AddPerson +AddMode row  -->
<div class="col mb-2 mt-3 mt-md-4">
	<h1 class="h5 d-inline align-middle my-2 mr-3">{{ __('navbar.recommendations') }}</h1>
	@if(auth::check())
	<div class="d-inline" ng-show="active_tab!='mood_pick'">
		<button class="btn btn-outline-secondary my-2" ng-show="party_members.length>0" type="button" disabled>{{ Auth::user()->name }}</button>
		<button class="btn btn-outline-secondary mr-2 my-2" type="button" ng-repeat="user in party_members" ng-click="remove_from_party(user.user_id);">@{{user.name}} <i class="fa fa-times"></i></button>
		<button id="addperson_button" class="btn btn-outline-secondary my-2" type="button" data-toggle="collapse" data-target="#collapseAdd" ng-click="setFocus('input_user')"><i class="fas fa-user-plus"></i><span id="addperson_text" class="d-none d-md-inline"> {{ __('general.add_person') }}</span></button>
	</div>
	@endif
	<div class="d-inline" ng-show="active_tab=='mood_pick'">
		<button class="btn btn-outline-secondary mr-2 my-2" type="button" ng-repeat="mode_movie in mode_movies" ng-click="remove_from_mode(mode_movie.id);" data-toggle="tooltip" data-placement="top" title="@{{mode_movies.original_title}}">@{{mode_movie.title}}@{{mode_movie.release_date.length > 0 ? ' ('+mode_movie.release_date.substring(0, 4)+')' : ''}} <i class="fa fa-times"></i></button>
		<button id="addmovie_button" class="btn btn-outline-secondary my-2" type="button" data-toggle="collapse" data-target="#collapseAdd" ng-click="setFocus('input_mode')"><i class="fas fa-plus"></i> <span ng-show="mode_movies.length == 0">{{ __('general.pick_mode') }}</span><span ng-hide="mode_movies.length == 0"> {{ __('general.add_movie') }}</span></button>
	</div>
</div>
<!-- H1 +AddPerson +AddMode row  -->




<!-- AddPerson / AddMode section -->
<div class="collapse container-fluid background-lightgrey" id="collapseAdd">
	<div class="row">
		<div class="col"></div>
		<div class="input-group input-group-lg col-12 col-xl-8" id="scroll_toppest_point">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
			</div>
			<input type="text" id="input_user" class="form-control" placeholder="{{ __('general.search_user') }}" aria-describedby="basic-addon1" ng-model="search_text" ng-change="search_get_first()" ng-model-options="{debounce: 750}" ng-show="active_tab!='mood_pick'">
			<input type="text" id="input_mode" class="form-control" placeholder="{{ __('general.search_movie') }}" aria-describedby="basic-addon1" ng-model="search_mode_text" ng-change="search_get_first()" ng-model-options="{debounce: 750}" ng-show="active_tab=='mood_pick'">
		</div>
		<div class="col"></div>
	</div>

	<div class="py-3" ng-if="active_tab!='mood_pick'">
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
	<div class="py-3" ng-if="active_tab=='mood_pick'">
		@if(auth::check())
		<div class="container-fluid mb-3" ng-hide="is_mode_search">
			<div class="dropdown d-inline" ng-init="mode_mod_title='{{ __('general.definitely_recommend_movies') }}';">
				<button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@{{mode_mod_title}}
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<button class="dropdown-item" ng-click="mode_mod_title='{{ __('general.definitely_recommend_movies') }}';change_mode_active_tab(5);search_get_first()">{{ __('general.definitely_recommend') }}</button>
					<button class="dropdown-item" ng-click="mode_mod_title='{{ __('general.recommend_movies') }}';change_mode_active_tab(4);search_get_first()">{{ __('general.recommend') }}</button>
					<button class="dropdown-item" ng-click="mode_mod_title='{{ __('general.not_sure_movies') }}';change_mode_active_tab(3);search_get_first()">{{ __('general.not_sure') }}</button>
					<button class="dropdown-item" ng-click="mode_mod_title='{{ __('general.dont_recommend_movies') }}';change_mode_active_tab(2);search_get_first()">{{ __('general.dont_recommend') }}</button>
					<button class="dropdown-item" ng-click="mode_mod_title='{{ __('general.definitely_dont_recommend_movies') }}';change_mode_active_tab(1);search_get_first()">{{ __('general.definitely_dont_recommend') }}</button>
					<div class="dropdown-divider"></div>
					<button class="dropdown-item" ng-click="mode_mod_title='{{ __('general.all_movies') }}';change_mode_active_tab('all');search_get_first()">{{ __('general.all') }}</button>
				</div>
			</div>
			<span class="text-muted pl-2"><small>@{{in_mode}} <span ng-show="in_mode < 2">{{ strtolower(__('general.movie')) }}</span><span ng-show="in_mode > 1">{{ strtolower(__('general.movies')) }}</span></small></span>
		</div>
		@endif
		<span class="h6 text-muted d-block" ng-show="is_mode_search">{{ __('general.search_results') }}</span>

		@if(auth::check())
		<div class="p-5" ng-show="search_movies.length==0">
		@else
		<div class="p-5" ng-show="search_movies.length==0 && is_mode_search">
		@endif
			<div class="text-muted text-center">{{ __('general.no_result') }}</div>
		</div>

		<div class="d-flex flex-wrap">
			<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-2 px-1" ng-repeat="movie in search_movies">
				<div class="card moviecard h-100 d-flex flex-column justify-content-between">
					<a ng-href="/movie/@{{movie.id}}" target={{$target}} data-toggle="tooltip" data-placement="top" title="@{{movie.original_title}}">
						<img class="card-img-top" ng-src="{{config('constants.image.thumb_nail')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
						<div class="card-block">
							<h6 class="card-title px-1 pt-1 text-muted text-center">@{{movie.title}} <small class="text-muted" ng-if="movie.release_date.length > 0"><em>(@{{movie.release_date.substring(0, 4)}})</em></small></h6>
						</div>
					</a>
					<div class="card-footer p-0">
						<div class="row no-gutters">
							<div class="col">
								<button type="button" class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-click="add_to_mode(movie)"><i class="fa fa-plus"></i> {{ __('general.add') }}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div ng-hide="active_tab=='mood_pick'">@include('layout.pagination', ['suffix' => '_search'])</div>
	<div ng-show="active_tab=='mood_pick'">@include('layout.pagination', ['suffix' => '_mode'])</div>
	<div class="text-center pb-1">
		<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" data-toggle="collapse" data-target="#collapseAdd" ng-click="reset_add_person_input()"><i class="fa fa-angle-up"></i></button>
	</div>
</div>
<!-- AddPerson / AddMode section -->




<!-- Tabs Button -->
<div class="container-fluid mt-3 pb-1 d-none d-md-inline" id="filter">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='top_rated'}" ng-click="active_tab='top_rated';get_first_page_data()">{!! __('general.according_to_popular_taste') !!}</button>
		</li>
		<!--<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='popular'}" ng-click="active_tab='popular';get_first_page_data()">{{ __('general.most_populer') }}</button>
		</li>-->
		<li class="nav-item mb-2">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='pemosu'}" ng-click="active_tab='pemosu';get_first_page_data()" {{ auth::check()?null:'disabled' }}>{{ __('general.according_to_my_taste') }}</button>
		</li>
		<li class="nav-item mb-2">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='mood_pick'}" ng-click="active_tab='mood_pick';get_first_page_data()">{!! __('general.according_to_movie_combination') !!}</button>
		</li>
		<!--<li class="nav-item ml-3 pb-2">
			<button id="filter_button" class="nav-link btn btn-outline-secondary btn-sm" ng-click="drawslider();scroll_to_filter()" type="button" data-toggle="collapse" data-target="#collapseFilter" ng-disabled="{{ auth::check()?'false':'true' }} && active_tab=='top_rated'"><i class="fa fa-filter"></i> {{ __('general.filter') }}</button>
		</li>-->
	</ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu d-md-none tab2">
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='top_rated'}" ng-click="active_tab='top_rated';get_first_page_data()">{!! __('general.according_to_popular_taste') !!}</button>
	@if(auth::check())
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='pemosu'}" ng-click="active_tab='pemosu';get_first_page_data()">{{ __('general.according_to_my_taste') }}</button>
	@endif
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='mood_pick'}" ng-click="active_tab='mood_pick';get_first_page_data()">{!! __('general.according_to_movie_combination') !!}</button>
</div>
<!-- Tabs Button Mobile -->




<!-- Sort by and Filter section -->
<div class="container-fluid">
	<div class="dropdown d-inline mr-2" ng-init="sort_by_title_2='{{ __('general.top_rated') }}';" ng-show="active_tab=='top_rated'">
		<button class="btn btn-outline-secondary dropdown-toggle mt-3" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-sort-amount-down"></i> @{{sort_by_title_2}}
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
			<button class="dropdown-item" ng-click="sort_by_title_2='{{ __('general.top_rated') }}';change_sort_by('top_rated');">{{ __('general.top_rated') }}</button>
			<button class="dropdown-item" ng-click="sort_by_title_2='{{ __('general.most_populer') }}';change_sort_by('most_popular');">{{ __('general.most_populer') }}</button>
		</div>
	</div>
	@if(auth::check())
		@if(Auth::User()->advanced_filter)
	<div class="dropdown d-inline mr-2" ng-init="sort_by_title_4='{{ __('general.sort_by_match') }}';" ng-hide="active_tab=='top_rated'">
		<button class="btn btn-outline-secondary dropdown-toggle mt-3" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-sort-amount-down"></i> @{{sort_by_title_4}}
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
			<button class="dropdown-item" ng-click="sort_by_title_4='{{ __('general.sort_by_match') }}';change_sort_by('point');">{{ __('general.sort_by_match') }}</button>
			<button class="dropdown-item" ng-click="sort_by_title_4='{{ __('general.sort_by_percent') }}';change_sort_by('percent');">{{ __('general.sort_by_percent') }}</button>
			<button class="dropdown-item" ng-click="sort_by_title_4='{{ __('general.top_rated') }}';change_sort_by('top_rated');">{{ __('general.top_rated') }}</button>
			<button class="dropdown-item" ng-click="sort_by_title_4='{{ __('general.most_populer') }}';change_sort_by('most_popular');">{{ __('general.most_populer') }}</button>
		</div>
	</div>
		@endif
	@endif
	<div class="dropdown d-inline">
		<button id="filter_button" class="btn btn-outline-secondary mt-3" ng-click="drawslider();scroll_to_filter()" type="button" data-toggle="collapse" data-target="#collapseFilter" ng-disabled="{{ auth::check()?'false':'true' }} && active_tab=='top_rated'"><i class="fa fa-filter"></i> {{ __('general.filter') }}</button>
	</div>
</div>
<!-- Sort by and Filter section -->




<!-- Filter secion -->
<div class="collapse container-fluid background-lightgrey mb-3" id="collapseFilter">
	@include('layout.recommendations_languages')
	@include('layout.recommendations_genres')
	<div class="mt-3 pb-3">
		<p class="h6 text-muted">{{ __('general.year') }}</p>
		<rzslider rz-slider-model="slider.minValue"
		rz-slider-high="slider.maxValue"
		rz-slider-options="slider.options"></rzslider>
	</div>
	@if(auth::check())
		@if(Auth::User()->advanced_filter)
	<div class="mt-3 pb-3">
		<p class="h6 text-muted">{{ __('general.min_vote_count') }}</p>
		<rzslider rz-slider-model="slider_vote_count.value"
		rz-slider-options="slider_vote_count.options"></rzslider>
	</div>
	<div class="mt-3 pb-3">
		<p class="h6 text-muted">{{ __('general.other') }}</p>
		<div class="col">
			<div class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" id="customCheckWL" ng-model="f_add_watched" ng-change="get_first_page_data()">
			  <label class="custom-control-label" for="customCheckWL">{{ __('general.show_watched_movies') }}</label>
			</div>
		</div>
	</div>
		@endif
	@endif
	<div class="text-center pb-1">
		<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" data-toggle="collapse" data-target="#collapseFilter"><i class="fa fa-angle-up" ng-click="scroll_to_filter()"></i></button>
	</div>
</div>
<!-- Filter secion -->




<!-- MovieCard -->
<div id="scroll_top_point">
	<div class="p-5" ng-show="movies.length==0">
		<div class="text-muted text-center"><span ng-if="!is_waiting && !(active_tab=='mood_pick' && mode_movies.length==0)">{{ __('general.no_result') }}</span><span ng-if="!is_waiting && active_tab=='mood_pick' && mode_movies.length==0">{{ __('general.no_mode_movies') }}</span><span ng-if="is_waiting">{{ __('general.searching') }}</span></div>
	</div>
	@include('layout.moviecard')
</div>

@include('layout.pagination', ['suffix' => ''])
<!-- MovieCard -->

@endsection