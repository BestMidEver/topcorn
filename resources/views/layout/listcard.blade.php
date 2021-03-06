<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="list in listes" ng-cloak>
	<div class="card moviecard h-100 d-flex flex-column justify-content-between mx-2">
		<a ng-href="/list/@{{list.id}}" target={{$target}} data-toggle="tooltip" data-placement="top" title="@{{list.entry_1}}@{{list.entry_1_raw.length==51?'...':''}}">
			<div class="position-relative text-center">
				<div class="card-group no-gutters darken-cover">
					<div class="col-6">
						<img class="card-img-top border-no-radius" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m1_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					</div>
					<div class="col-6">
						<img class="card-img-top border-no-radius" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m2_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					</div>
					<div class="col-6">
						<img class="card-img-top border-no-radius" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m3_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					</div>
					<div class="col-6">
						<img class="card-img-top border-no-radius" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m4_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					</div>
					<div class="col-6">
						<img class="card-img-top border-no-radius" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m5_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					</div>
					<div class="col-6">
						<img class="card-img-top border-no-radius" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m6_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					</div>
				</div>
				<!--<div class="custom-over-layer h-50 d-flex flex-column justify-content-center">
					<div class="d-flex flex-row justify-content-center">
						<div class="text-white">
							<small>{{ __('general.according_to_your_taste') }}</small>
							<span class="d-block"><span class="h5 text-warning">{{ __('general.moviecard_percent') }}</span><small> {{ __('general.match') }}</small></span>
							@if(Auth::check())
								@if(Auth::User()->advanced_filter)
							<small><span class="h5 text-warning">@{{movie.point*1+movie.p2*1}}</span>/@{{movie.p2*2}} {{ __('general.point') }}</small>
								@endif
							@endif
						</div>
					</div>
				</div>-->
				<div class="custom-over-layer-bottom h-50 d-flex flex-column justify-content-center">
					<div class="d-flex flex-row justify-content-center" ng-if="list.like_count > 0">
						<div class="text-white">
							<span class="d-block"><span class="h5 text-warning">@{{list.like_count}}</span> <small ng-hide="list.like_count>1">{{ __('general.like_count') }}</small><small ng-show="list.like_count>1">{{ __('general.like_counts') }}</small></span>
						</div>
					</div>
				</div>
				<!--<div class="p-2 text-right moviecard-percent">
					<div><span class="badge btn-verydark text-white">44</span></div>
				</div>-->
				<div class="p-2 text-right moviecard-rating" ng-if="list.like_count > 0">
					<div><span class="badge btn-verydark text-white">@{{list.like_count}}</span></div>
				</div>
			</div>
			<div class="card-block">
				<h6 class="card-title px-1 py-1 my-0 text-dark text-left">@{{list.title}} <small class="text-muted d-block pt-1"><em>(@{{list.updated_at}})</em></small></h6>
			</div>
		</a>
	</div>
</div>







