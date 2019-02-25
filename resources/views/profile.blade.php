@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_profile')

@section('body')
<div class="position-relative mt-md-4">
	<img ng-src="{{config('constants.image.cover')[$image_quality]}}{{ $profile_cover_pic }}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
	<div class="coveroverlayersmall-profile d-md-none">
		<div class="d-flex flex-column align-items-center">
			<div class="d-flex flex-column">
				<div class="d-flex flex-row align-items-center">
					<div class="d-flex flex-column">
						<img ng-src="{{ $profile_profile_pic }}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicsmall" alt="Responsive image">
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex flex-row align-items-center ml-2">
							<h5><span class="yeswrap text-left text-light">{{ $profile_user_name }}@if($is_following_you != -1) <small>({{ __('general.follows_you') }})</small>@endif</span></h5>
						</div>
						<div class="d-flex flex-row align-items-center text-light ml-2">
							@if($profile_watched_movie_number > 0)
							<div data-toggle="tooltip" data-placement="top" title="{{ __('general.watched_movie_number') }}">
								<i class="fas fa-film mr-1"></i><div class="d-inline" >{{ $profile_watched_movie_number }}</div>
							</div>
							@endif
							@if($profile_watched_series_number > 0)
							<div class="pl-2 pl-sm-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.watched_series_number') }}">
								<i class="fas fa-tv mr-1"></i><div class="d-inline" >{{ $profile_watched_series_number }}</div>
							</div>
							@endif
							@if($review_number > 0)
							<div class="pl-2 pl-sm-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.review_number') }}">
								<i class="fas fa-pencil-alt mr-1"></i><div class="d-inline" >{{ $review_number }}</div>
							</div>
							@endif
							@if($list_number > 0)
							<div class="pl-2 pl-sm-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.list_number') }}">
								<i class="fas fa-th-list mr-1"></i><div class="d-inline" >{{ $list_number }}</div>
							</div>
							@endif
							@if($like_number > 0)
							<div class="pl-2 pl-sm-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.like_number') }}">
								<i class="fas fa-heart mr-1"></i><div class="d-inline" >{{ $like_number }}</div>
							</div>
							@endif
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
						<h5><span class="yeswrap text-left text-light">{{ $profile_user_name }}@if($is_following_you != -1) <small>({{ __('general.follows_you') }})</small>@endif</span></h5>
					</div>
					<div class="d-flex flex-row align-items-center text-light ml-2">
						@if($profile_watched_movie_number > 0)
						<div data-toggle="tooltip" data-placement="top" title="{{ __('general.watched_movie_number') }}">
							<i class="fas fa-film"></i><div class="d-inline pl-1" >{{ $profile_watched_movie_number }}</div>
						</div>
						@endif
						@if($profile_watched_series_number > 0)
						<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.watched_series_number') }}">
							<i class="fas fa-tv"></i><div class="d-inline pl-1" >{{ $profile_watched_series_number }}</div>
						</div>
						@endif
						@if($review_number > 0)
						<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.review_number') }}">
							<i class="fas fa-pencil-alt"></i><div class="d-inline pl-1" >{{ $review_number }}</div>
						</div>
						@endif
						@if($list_number > 0)
						<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.list_number') }}">
							<i class="fas fa-th-list"></i><div class="d-inline pl-1" >{{ $list_number }}</div>
						</div>
						@endif
						@if($like_number > 0)
						<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.like_number') }}">
							<i class="fas fa-heart"></i><div class="d-inline pl-1" >{{ $like_number }}</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	@if(Auth::check())
	<div class="right-top">
		@if($profile_user_id == Auth::user()->id)
		<a class="btn btn-link mt-2 mr-2 text-light" href="/account"><i class="fa fa-cog" aria-hidden="true"></i><span class="d-none d-md-inline"> {{ __('navbar.account') }}</span></a>
		@endif
	</div>
	@endif
	<div class="right-bottom pr-2 fa30">
		@if($another_link_url)
		<a class="btn btn-link mb-2 text-light btn-sm" ng-if="'{{$another_link_url}}' != ''" href="{{$another_link_url}}" data-toggle="tooltip" data-placement="top" title="{{ $another_link_url }}" target="_blank"><span class="h6">{{$another_link_name ? $another_link_name : __('general.personal_website')}}</span></a>
		@endif

		@if($facebook_link)
		<a class="btn btn-link mb-2 text-light btn-sm" href="{{config('constants.facebook.link').$facebook_link}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_facebook') }}"><i class="fab fa-facebook-square"></i></a>
		@endif
		@if($instagram_link)
		<a class="btn btn-link mb-2 text-light btn-sm" href="{{config('constants.instagram.link').$instagram_link}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_instagram') }}"><i class="fab fa-instagram"></i></a>
		@endif
		@if($twitter_link)
		<a class="btn btn-link mb-2 text-light btn-sm" href="{{config('constants.twitter.link').$twitter_link}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_twitter') }}"><i class="fab fa-twitter-square"></i></a>
		@endif
		@if($youtube_link)
		<a class="btn btn-link mb-2 text-light btn-sm" href="{{config('constants.youtube.link').$youtube_link}}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('general.users_youtube') }}"><i class="fab fa-youtube-square"></i></a>
		@endif
	</div>
</div>


@if(Auth::check())
<div class="d-flex flex-wrap justify-content-between">
	<div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto">
		<div class="d-flex flex-row justify-content-between text-center">
			@if($profile_user_id != Auth::user()->id)
			<a class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addblack" href="/recommendations/{{$profile_user_id}}"><div><i class="fa fa-plus"></i></div><span class="scrollmenu">{{ __('general.watch_together') }}</span></a>
			<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addblack" ng-class="{'text-success':page_variables.follow_id != -1}" ng-click="toggle_follow()" ng-mouseenter="hovering_fol=true" ng-mouseleave="hovering_fol=false">
				<div><i class="fas" ng-class="page_variables.follow_id == -1 ? 'fa-user' : 'fa-user-friends'"></i></div>
				<span class="scrollmenu" ng-show="page_variables.follow_id == -1">{{ __('general.follow') }}</span>
				<span class="scrollmenu" ng-hide="page_variables.follow_id == -1"><span ng-hide="hovering_fol">{{ __('general.following') }}</span><span ng-show="hovering_fol">{{ __('general.unfollow') }}</span></span>
			</button>
			@endif
		</div>
	</div>
</div>
@endif


<!--
<div class="scrollmenu mt-3 tab2">
	<div class="btn-group d-block mb-2 mb-md-0 text-center" role="group" aria-label="Movies or Series">
		<button type="button" class="btn" ng-class="page_variables.movies_or_series=='movies'?'btn-tab':'btn-outline-tab'" ng-click="switch_page_mode('movies')">{{ __('general.p_movies') }}</button>
		<button type="button" class="btn" ng-class="page_variables.movies_or_series=='series'?'btn-tab':'btn-outline-tab'" ng-click="switch_page_mode('series')">{{ __('general.p_series') }}</button>
	</div>
</div>
-->




<!-- Tabs Button -->
<div class="container-fluid mt-3 d-none d-md-inline">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab!='get_laters' && active_tab!='get_bans' && active_tab!='get_lists' && active_tab!='get_reviews' && active_tab!='get_follows'}" ng-click="mod_title='{{ __('general.all') }}';active_tab='get_rateds/all';get_first_page_data()">{{ __('general.seen_movies') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_laters'}" ng-click="active_tab='get_laters';get_first_page_data();">{{ __('general.watch_later') }}</button>
		</li>
		<li class="nav-item" ng-show="!page_variables.is_guest">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_bans'}" ng-click="active_tab='get_bans';get_first_page_data();">{{ __('general.banneds') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_lists'}" ng-click="active_tab='get_lists';list_mode='created_ones';get_first_page_data();">{{ __('general.lists') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_reviews'}" ng-click="active_tab='get_reviews';get_first_page_data();">Reviews</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_follows'}" ng-click="active_tab='get_follows';follows_mode='following';get_first_page_data();">Follows</button>
		</li>
	</ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu mt-3 d-md-none tab2">
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab!='get_laters' && active_tab!='get_bans' && active_tab!='get_lists' && active_tab!='get_reviews' && active_tab!='get_follows'}" ng-click="mod_title='{{ __('general.all') }}';active_tab='get_rateds/all';get_first_page_data()">{{ __('general.seen_movies') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='get_laters'}" ng-click="active_tab='get_laters';get_first_page_data();">{{ __('general.watch_later') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='get_bans'}" ng-show="!page_variables.is_guest" ng-click="active_tab='get_bans';get_first_page_data();">{{ __('general.banneds') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='get_lists'}" ng-click="active_tab='get_lists';list_mode='created_ones';get_first_page_data();">{{ __('general.lists') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='get_reviews'}" ng-click="active_tab='get_reviews';get_first_page_data();">{{ __('general.lists') }}</button>
	<button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':active_tab=='get_follows'}" ng-click="active_tab='get_follows';follows_mode='following';get_first_page_data();">{{ __('general.lists') }}</button>
</div>
<!-- Tabs Button Mobile -->



<div class="container-fluid">
	<div class="btn-group mr-2" role="group" aria-label="Movies or Series">
		<button type="button" class="btn btn-outline-secondary" ng-class="page_variables.movies_or_series=='movies'?'active':''" ng-click="switch_page_mode('movies')">{{ __('general.p_movies') }}</button>
		<button type="button" class="btn btn-outline-secondary" ng-class="page_variables.movies_or_series=='series'?'active':''" ng-click="switch_page_mode('series')">{{ __('general.p_series') }}</button>
	</div>

	<div class="d-inline" ng-show="active_tab!='get_laters' && active_tab!='get_bans' && active_tab!='get_lists' && active_tab!='get_reviews' && active_tab!='get_follows' && !is_waiting">
		<div class="dropdown d-inline" ng-init="mod_title='{{ __('general.all') }}'">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
		<span class="text-muted pl-2" ng-hide="page_variables.movies_or_series=='series'"><small>@{{in}} <span ng-show="in < 2">{{ strtolower(__('general.movie')) }}</span><span ng-show="in > 1">{{ strtolower(__('general.movies')) }}</span></small></span>
		<span class="text-muted pl-2" ng-show="page_variables.movies_or_series=='series'"><small>@{{in}} <span ng-show="in < 2">{{ strtolower(__('general.series')) }}</span><span ng-show="in > 1">{{ strtolower(__('general.seriess')) }}</span></small></span>
	</div>

	<div class="d-inline" ng-show="active_tab=='get_lists' && !is_waiting">
		<div class="dropdown d-inline" ng-init="list_mod_title='{{ __('general.created_ones') }}';">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				@{{list_mod_title}}
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="list_mod_title='{{ __('general.created_ones') }}';list_mode='created_ones';get_first_page_data();">{{ __('general.created_ones') }}</button>
				<button class="dropdown-item" ng-click="list_mod_title='{{ __('general.liked_ones') }}';list_mode='liked_ones';get_first_page_data();">{{ __('general.liked_ones') }}</button>
			</div>
		</div>
	</div>

	<div class="d-inline" ng-show="active_tab=='get_follows' && !is_waiting">
		<div class="dropdown d-inline" ng-init="follow_mod_title='{{ __('general.followings') }}';">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				@{{follow_mod_title}}
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="follow_mod_title='{{ __('general.following') }}';follows_mode='following';get_first_page_data();">{{ __('general.followings') }}</button>
				<button class="dropdown-item" ng-click="follow_mod_title='{{ __('general.followers') }}';follows_mode='followers';get_first_page_data();">{{ __('general.followers') }}</button>
			</div>
		</div>
	</div>

	<div class="d-inline" ng-show="active_tab=='get_laters' && page_variables.movies_or_series == 'series' && !page_variables.is_guest && !is_waiting">
		<div class="dropdown d-inline" ng-init="page_variables.active_dropdown_3 = 'all'">
			<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span ng-if="page_variables.active_dropdown_3=='unseen'">{{ __('general.unseen') }}</span>
				<span ng-if="page_variables.active_dropdown_3=='available'">{{ __('general.available') }}</span>
				<span ng-if="page_variables.active_dropdown_3=='awaited'">{{ __('general.awaited') }}</span>
				<span ng-if="page_variables.active_dropdown_3=='all'">{{ __('general.all') }}</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="switch_seen_unseen('unseen')">{{ __('general.unseen') }}</button>
				<button class="dropdown-item" ng-click="switch_seen_unseen('available')">{{ __('general.available') }}</button>
				<button class="dropdown-item" ng-click="switch_seen_unseen('awaited')">{{ __('general.awaited') }}</button>
				<div class="dropdown-divider"></div>
				<button class="dropdown-item" ng-click="switch_seen_unseen('all')">{{ __('general.all') }}</button>
			</div>
		</div>
		<span class="text-muted pl-2"><small>@{{in}} <span ng-show="in < 2">{{ strtolower(__('general.series')) }}</span><span ng-show="in > 1">{{ strtolower(__('general.seriess')) }}</span></small></span>
	</div>
</div>


<div id="scroll_top_point">
	<div class="p-5" ng-show="(active_tab != 'get_lists' && movies.length==0) || (active_tab == 'get_lists' && listes.length==0) || (active_tab == 'get_follows' && page_variables.follows.length==0) || is_waiting">
		<div class="text-muted text-center" ng-if="!is_waiting">{{ __('general.no_result') }}</div><div class="text-muted text-center" ng-if="is_waiting">{{ __('general.searching') }}</div>
	</div>
	@include('layout.moviecard')
	<div class="card-group no-gutters">
		@include('layout.listcard')
		@if(Auth::check())
			@if($profile_user_id == Auth::user()->id)
		<div class="col-6 col-md-4 col-lg-3 col-xl-2 my-5 py-5" ng-if="active_tab=='get_lists'">
			<div class="h-100 d-flex flex-column justify-content-center mx-2">
				<div class="d-flex flex-row justify-content-center">
					<a href="/createlist/new" class="btn btn-verydark border-circle text-white btn-lg" data-toggle="tooltip" data-placement="top" title="{{ __('general.create_list') }}" target={{$target}}><i class="fas fa-plus"></i></a>
				</div>
			</div>
		</div>
			@endif
		@endif
	</div>
	<div class="container-fluid" ng-if="active_tab=='get_reviews'">
		<div ng-if="page_variables.reviews.length>0" class="py-4" ng-repeat="review in page_variables.reviews" ng-hide="review.content==''">
			<div class="d-flex justify-content-between">
				<div class="d-inline"><a class="h6 pb-2 text-dark d-inline" ng-href="/@{{review.mode==1?'movie':'series'}}/@{{review.movie_series_id}}" data-toggle="tooltip" data-placement="top" title="@{{review.original_title}}">@{{review.movie_title}} <small class="text-muted" ng-if="review.release_date.length > 0"><em>(@{{review.release_date.substring(0, 4)}})</em></small></a> <span class="ml-2" ng-if="review.rate>0"><i class="fas fa-star" ng-class="{1:'text-danger', 2:'text-warning', 3:'text-secondary', 4:'text-info', 5:'text-success'}[review.rate]" ng-repeat="n in [] | range:review.rate"></i><i class="far fa-star text-muted" ng-repeat="n in [] | range:(5-review.rate)"></i></span></div>
				<div class="h6">
					<button class="btn btn-outline-secondary btn-sm border-0 mt-0 addseen opacity-1" ng-disabled="!page_variables.is_guest" ng-click="like_review($index)">
						<div ng-class="{'text-success':review.count>0}"><i class="fa-heart" ng-class="{0:'far', 1:'fas', undefined:'far'}[review.is_liked]"></i><span ng-if="review.count>0"> @{{review.count}}</span></div>
					</button>
				</div>
			</div>
			<div id="@{{'accordion'+$index}}">
				<div ng-if="review.id == 'long'">
					<div id="@{{'collapse'+$index+'a'}}" data-parent="@{{'#accordion'+$index}}" class="lead lead-small collapse">
						<div>
							<div ng-bind-html="review.content"></div>
						</div>
						<div class="text-center pt-0">
							<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white hidereview" data-toggle="collapse" data-target="@{{'#collapse'+$index+'b'}}" aria-expanded="true"><i class="fa fa-angle-up"></i></button>
						</div>
					</div>
				</div>
				<div>
					<div id="@{{'collapse'+$index+'b'}}" data-parent="@{{'#accordion'+$index}}" class="lead lead-small collapse show">
						<div>
							<div ng-bind-html="review.url"></div>
						</div>
						<div ng-if="review.id == 'long'">
							<div class="text-center pt-1">
								<button class="btn btn-outline-secondary border-0 text-muted hover-white showreview" data-toggle="collapse" data-target="@{{'#collapse'+$index+'a'}}" aria-expanded="false"><small>{{ __('general.read_all') }}</small></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="p-5" ng-if="!page_variables.reviews.length>0 && active_tab=='get_reviews'">
		<div class="text-muted text-center">{{ __('general.no_result_review') }}</div>
	</div>

	<div class="d-flex flex-wrap" ng-show="active_tab=='get_follows'">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in page_variables.follows">
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
</div>
@include('layout.pagination', ['suffix' => ''])


@endsection
