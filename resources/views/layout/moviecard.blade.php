<div class="card-group no-gutters" ng-cloak>
	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="movie in movies">
		<div class="card moviecard h-100 d-flex flex-column justify-content-between mx-2">
			<a ng-href="/@{{movie.title.length>0?'movie':'series'}}/@{{movie.id}}" target={{$target}} data-toggle="tooltip" data-placement="top" title="@{{movie.original_title.length>0?movie.original_title:movie.original_name}}">
				<div class="position-relative text-center min-height-200">
					<img class="card-img-top darken-cover" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					<div class="custom-over-layer h-50 d-flex flex-column justify-content-center">
						<div class="d-flex flex-row justify-content-center" ng-if="movie.percent > 0">
							<div class="text-white">
								<small ng-if="active_tab!='mood_pick'">{{ __('general.according_to_your_taste') }}</small>
								<small ng-if="active_tab=='mood_pick'">{{ __('general.according_to_your_mood') }}</small>
								<span class="d-block"><span class="h5 text-warning">{!! __('general.moviecard_percent', ['suffix' => 'movie.percent']) !!}</span><small> {{ __('general.match') }}</small></span>
								@if(Auth::check())
									@if(Auth::User()->advanced_filter)
								<small ng-if="active_tab!='mood_pick'"><span class="h5 text-warning">@{{movie.point*1+movie.p2*1}}</span>/@{{movie.p2*2}} {{ __('general.point') }}</small>
									@endif
								@endif
								<small ng-if="active_tab=='mood_pick'"><span class="h5 text-warning">@{{movie.point}}</span>/@{{movie.count*5}} {{ __('general.point') }}</small>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-center" ng-if="!isNaN(movie.day_difference_last)">
							<div ng-hide="page_variables.is_guest">
								<div class="text-white" ng-if="movie.day_difference_last<1 && movie.last_seen_air_date.length>0">
									<small ng-if="movie.status=='Returning Series' || movie.next_episode>0">{{ __('general.new_episode') }}</small>
									<div>
										<span ng-if="movie.day_difference_next==null&&movie.status=='Returning Series'"><span class="h5 text-warning">{{  ucfirst(__('general.unknown')) }}</span></span>
										<span ng-if="movie.day_difference_next>1">{!! __('general.airs_days_later') !!}</span>
										<span ng-if="movie.day_difference_next==1">{!! __('general.airs_tomorrow') !!}</span>
										<span ng-if="movie.day_difference_next==0">{!! __('general.airs_today') !!}</span>
										<span ng-if="movie.day_difference_next<0" class="h5 text-warning">{{ __('general.available') }}</span>
										<span ng-if="movie.day_difference_last==0 && !movie.next_episode>0" class="h5 text-warning"><span ng-if="movie.status=='Ended'">{{ __('general.ended') }}</span><span ng-if="movie.status=='Canceled'">{{ __('general.canceled') }}</span></span>
									</div>
								</div>
								<div class="text-white" ng-if="movie.day_difference_last>0">
									<div ng-if="movie.next_episode>0" class="h5 text-warning mb-1"> S@{{movie.next_season>9?movie.next_season:'0'+movie.next_season}}E@{{movie.next_episode>9?movie.next_episode:'0'+movie.next_episode}}</div>
									<span class="d-block">
										<span ng-if="movie.day_difference_last==1" class="h5 text-warning">{{ __('general.yesterday') }}</span>
										<span ng-if="movie.day_difference_last>1" class="h5 text-warning">{{ __('general.available') }}</span>
									</span>
								</div>
								<div class="text-white" ng-if="!movie.last_seen_air_date.length>0 && movie.last_episode_air_date.length>0">
									<div>
										<span class="h5 text-warning">{{ __('general.unseen') }}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-center" ng-if="!isNaN(movie.profile_user_rate) && page_variables.is_guest && movie.profile_user_rate != null">
							<div>
								<div class="text-white">
									<small>{{ __('general.according_to_user') }}</small>
									<div>
										<span><i class="fas fa-star" ng-class="{1:'text-danger', 2:'text-warning', 3:'text-secondary', 4:'text-info', 5:'text-success'}[movie.profile_user_rate]" ng-repeat="n in [] | range:movie.profile_user_rate"></i><i class="far fa-star text-muted" ng-repeat="n in [] | range:(5-movie.profile_user_rate)"></i></span>
									</div>
								</div>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-center" ng-if="movie.updated_at.length>0">
							<div class="text-white">
								<small class="d-block">{{ __('general.vote_updated_at') }}</small>
								<small>@{{movie.updated_at}} {{ __('general.ago') }}</small>
							</div>
						</div>
					</div>
					<div class="custom-over-layer-bottom h-50 d-flex flex-column justify-content-center">
						<div class="d-flex flex-row justify-content-center" ng-if="movie.vote_average > 0">
							<div class="text-white">
								<small>{{ __('general.according_to_themoviedb') }}</small>
								<span class="d-block"><span class="h5 text-warning">@{{movie.vote_average}}</span><small>/10</small></span>
								<small ng-if="movie.vote_count > 0">@{{movie.vote_count}} <span ng-if="movie.vote_count == 1">{{ __('general.person_time') }}</span><span ng-if="movie.vote_count > 1">{{ __('general.person_times') }}</span></small>
							</div>
						</div>
					</div>
					<div class="p-2 text-right moviecard-percent" ng-if="movie.percent > 0">
						<div><span class="badge btn-verydark text-white">{!! __('general.moviecard_percent', ['suffix' => 'movie.percent']) !!}</span></div>
					</div>
					<div class="p-2 text-right moviecard-rating" ng-if="movie.vote_average > 0">
						<div><span class="badge btn-verydark text-white">@{{movie.vote_average}}</span></div>
					</div>
				</div>
				<div class="card-block">
					<h6 class="card-title px-1 py-1 my-0 text-dark text-left">@{{movie.title.length>0?movie.title:movie.name}} <small class="text-muted d-block pt-1" ng-if="movie.release_date.length > 0"><em>(@{{movie.release_date.substring(0, 4)}})</em></small><small class="text-muted d-block pt-1" ng-if="movie.first_air_date.length > 0"><em>(@{{movie.first_air_date.substring(0, 4)}})</em></small></h6>
				</div>
			</a>
			@if(Auth::check())
			<div class="card-footer p-0">
				<div class="row no-gutters">
					<div class="col">
						<button type="button" class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'text-warning':movie.later_id!=null}" ng-click="later($index)" data-toggle="tooltip" data-placement="bottom" title="{{ __('general.tooltip_watchlater') }}"><span ng-show="movie.later_id!=null"><i class="fas fa-clock"></i></span><span ng-show="movie.later_id==null"><i class="far fa-clock"></i></span></button>
					</div>
					<div class="col-7">
						<button type="button" class="btn btn-sm btn-block border-0" ng-class="rate_class(movie.rate_code)" ng-click="votemodal($index, movie)"><span ng-show="!movie.rate_code>0"><i class="far fa-star"></i></span><span ng-show="movie.rate_code>0"><i class="fas fa-check"></i></span> {{ __('general.seen') }}</button>
					</div>
					<div class="col">
						<button type="button" class="btn btn-outline-secondary btn-sm btn-block addban border-0" ng-class="{'text-danger':movie.ban_id!=null}" ng-click="ban($index)" data-toggle="tooltip" data-placement="bottom" title="{{ __('general.tooltip_ban') }}"><i class="fas fa-ban"></i></button>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>