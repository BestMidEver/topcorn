<div class="card-group no-gutters">
	<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="movie in movies">
		<div class="card moviecard h-100 d-flex flex-column justify-content-between mx-sm-2">
			<a href="/movie/@{{movie.id}}" data-toggle="tooltip" data-placement="top" title="@{{movie.original_title}}">
				<div class="position-relative">
					<img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					<div class="p-2 text-right moviecard-rating" ng-if="movie.vote_average > 0">
						<div><span class="badge badge-secondary">@{{movie.vote_average}}</span></div>
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
						<button type="button" class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'text-warning':movie.later_id!=null}" ng-click="later($index)"><i class="fa fa-clock-o" aria-hidden="true"></i></button>
					</div>
					<div class="col-7">
						<button type="button" class="btn btn-sm btn-block border-0" ng-class="rate_class(movie.rate_code)" ng-click="votemodal($index, movie)"><i class="fa fa-star-half-o" aria-hidden="true"></i> {{ __('general.seen') }}</button>
					</div>
					<div class="col">
						<button type="button" class="btn btn-outline-secondary btn-sm btn-block addban border-0" ng-class="{'text-danger':movie.ban_id!=null}" ng-click="ban($index)"><i class="fa fa-ban" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>