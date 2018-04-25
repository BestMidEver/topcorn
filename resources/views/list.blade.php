@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<div class="row no-gutters">
	<div class="col"></div>
	<div class="col-12 col-lg-10 col-xl-8">
		<div class="d-flex d-row">
			<h1 class="h5 text-center text-md-left col mt-3 mt-md-4 d-inline">{{ $liste[0]->title }}</h1>
			@if(Auth::check())
				@if($liste[0]->user_id == Auth::id())
			<div class="btn-group mt-2">
				<button type="button" class="text-right btn btn-outline-secondary border-0 addfacebook border-no-radius mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-v"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="/createlist/{{ $liste[0]->id }}">{{ __('general.edit') }}</a>
					<button class="dropdown-item" ng-click="confirm_delete({{ $liste[0]->id }},'{{ __('general.list_remove_confirm') }}')">{{ __('general.remove') }}</button>
				</div>
			</div>
				@endif
			@endif
		</div>

		<div class="py-3">
			<h6 class="lead">{{ $liste[0]->entry_1 }}</h6>
		</div>

		<div class="container-fluid mt-3">
			<div class="row mt-5" ng-repeat="movie in movies">
				<div class="col-12">
					<div class="card h-100">
						<div class="d-flex flex-wrap justify-content-between">
							<div class="p-1">
								<a ng-href="/movie/@{{movie.id}}" ng-attr-id="movie-@{{movie.id}}" data-toggle="tooltip" data-placement="top" title="@{{movie.original_title}}">
									<h6 class="text-dark p-1 text-hover-underline">
										@if($liste[0]->sort != 0)
										<span>@{{ movie.position }}.</span> 
										@endif
										@{{ movie.title }} <small class="text-muted" ng-if="movie.release_date.length > 0"><em>(@{{movie.release_date.substring(0, 4)}})</em></small></h6>
									</a>
								</div>
								@if(Auth::check())
								<div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto ml-auto">
									<div class="d-flex flex-row justify-content-between text-center">
										<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addlater" ng-class="{'text-warning':movie.later_id!=null}" ng-click="later($index)" title="{{ __('general.tooltip_watchlater') }}" data-toggle="tooltip" data-placement="top"><div><span ng-show="movie.later_id!=null"><i class="fas fa-clock"></i></span><span ng-show="movie.later_id==null"><i class="far fa-clock"></i></span></div></button>
										<button type="button" class="btn btn-sm btn-block border-0 mt-0 px-lg-4 addseen" ng-class="rate_class(movie.rate_code)" ng-click="votemodal($index, movie)" title="{{ __('general.seen') }}" data-toggle="tooltip" data-placement="top"><div><span ng-show="!movie.rate_code>0"><i class="far fa-star"></i></span><span ng-show="movie.rate_code>0"><i class="fas fa-check"></i></span></div></button>
										<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-class="{'text-danger':movie.ban_id!=null}" ng-click="ban($index)" title="{{ __('general.tooltip_ban') }}" data-toggle="tooltip" data-placement="top"><div><i class="fas fa-ban"></i></div></button>
									</div>
								</div>
								@endif
							</div>
							<div class="row no-gutters pt-3 pt-md-2">
								<div class="col-4 col-md-3 col-xl-2">
									<a ng-href="/movie/@{{movie.id}}" ng-mouseover="show_tooltip('movie-'+movie.id)" ng-mouseleave="hide_tooltip('movie-'+movie.id)()">
										<img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top" alt="Responsive image">
									</a>
								</div>

								<div class="col-8 col-md-9 col-xl-10 lead lead-small" ng-if="!movie.explanation">
									<div class="pr-1 pb-1 text-dark quote-line">@{{ movie.overview }}</div>
								</div>
								<div class="col-8 col-md-9 col-xl-10 lead lead-small" ng-if="movie.explanation">
									<div class="pl-3 pr-1 pb-1 text-dark line-break">@{{ movie.explanation }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="py-3 mt-5">
				<h6 class="lead">{{ $liste[0]->entry_2 }}</h6>
			</div>

			<div class="mt-5 d-flex flex-row justify-content-between">
				<div class="d-flex flex-column">
					<a href="/profile/{{ $liste[0]->user_id }}#!#Lists" class="text-no-decoration">
						<div class="d-flex flex-row">
							<div class="d-flex flex-column">
								<img ng-src="{{ $liste[0]->profile_pic }}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="list-thumbnail" alt="Responsive image">
							</div>
							<div class="d-flex flex-column justify-content-center ml-2">
								<h6 class="text-dark text-hover-underline mb-0">{{ $liste[0]->name }}</h6>
								<div class="text-muted"><small class="text-no-decoration">{{ __('general.ago_message', ['created_at' => timeAgo($created_at) , 'updated_at' => timeAgo($updated_at)]) }}</small></div>
							</div>
						</div>
					</a>
				</div>
				<div class="d-flex flex-column mt-3 ml-1 fa22">
					<div class="d-flex flex-row">
						<button class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addseen opacity-1" ng-class="{'text-success':is_liked}" ng-click="like_list()" ng-disabled="{{Auth::check()==1?'false':'true'}}">
							<div><i class="fas fa-heart" ng-show="is_liked"></i><i class="far fa-heart" ng-show="!is_liked"></i> @{{like_count}}</div>
							{{ __('general.like') }}
						</button>
						<a ng-href="{{config('constants.facebook.share_website')}}/list/{{$liste[0]->id}}" target="_blank" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addfacebook">
							<div><i class="fas fa-share"></i></div>
							{{ __('general.share') }}
						</a>
					</div>
				</div>
			</div>

		<!--<div class="container-fluid px-0 pt-5">
			<span class="h5 mb-0">{{ __('general.fb_comments') }}</span>
			<div class="fb-comments" data-href="https://topcorn.io/list/1" data-width="100%" data-numposts="6" data-colorscheme="{{Auth::check()?(Auth::User()->theme==1?'dark':'light'):''}}"></div>
		</div>-->
	</div>
	<div class="col"></div>
</div>
@endsection