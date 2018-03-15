<div class="card-group no-gutters">
	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="movie in movies">
		<div class="card moviecard h-100 d-flex flex-column justify-content-between mx-2">
			<a href="/movie/@{{movie.id}}" target={{$target}} data-toggle="tooltip" data-placement="top" title="@{{movie.original_title}}">
				<div class="position-relative text-center">
					<img class="card-img-top darken-cover" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					<div class="custom-over-layer h-50 d-flex flex-column justify-content-center">
						<div class="d-flex flex-row justify-content-center" ng-if="movie.percent > 0">
							<div class="text-white">
								<small>{{ __('general.according_to_your_taste') }}</small>
								<span class="d-block"><span class="h5 text-warning">%@{{movie.percent}}</span><small> {{ __('general.match') }}</small></span>
								@if(Auth::check())
									@if(Auth::User()->advanced_filter)
								<small><span class="h5 text-warning">@{{movie.point*1+movie.p2*1}}</span>/@{{movie.p2*2}} {{ __('general.point') }}</small>
									@endif
								@endif
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
						<div><span class="badge btn-verydark text-white">%@{{movie.percent}}</span></div>
					</div>
					<div class="p-2 text-right moviecard-rating" ng-if="movie.vote_average > 0">
						<div><span class="badge btn-verydark text-white">@{{movie.vote_average}}</span></div>
					</div>
				</div>
				<div class="card-block">
					<h6 class="card-title px-1 py-1 my-0 text-dark text-left">@{{movie.title}} <small class="text-muted d-block pt-1" ng-if="movie.release_date.length > 0"><em>(@{{movie.release_date.substring(0, 4)}})</em></small></h6>
				</div>
			</a>
			@if(Auth::check())
			<div class="card-footer p-0">
				<div class="row no-gutters">
					<div class="col">
						<button type="button" class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'text-warning':movie.later_id!=null}" ng-click="later($index)"><span ng-show="movie.later_id!=null"><i class="fas fa-clock"></i></span><span ng-show="movie.later_id==null"><i class="far fa-clock"></i></span></button>
					</div>
					<div class="col-7">
						<button type="button" class="btn btn-sm btn-block border-0" ng-class="rate_class(movie.rate_code)" ng-click="votemodal($index, movie)"><span ng-show="!movie.rate_code>0"><i class="far fa-star"></i></span><span ng-show="movie.rate_code>0"><i class="fas fa-check"></i></span> {{ __('general.seen') }}</button>
					</div>
					<div class="col">
						<button type="button" class="btn btn-outline-secondary btn-sm btn-block addban border-0" ng-class="{'text-danger':movie.ban_id!=null}" ng-click="ban($index)"><i class="fa fa-ban"></i></button>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>