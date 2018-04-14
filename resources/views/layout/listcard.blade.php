<div class="card-group no-gutters">
	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="list in listes">
		<div class="card moviecard h-100 d-flex flex-column justify-content-between mx-2">
			<a href="#" target={{$target}}>
				<div class="position-relative text-center">
					<div class="card-group no-gutters darken-cover">
						<div class="col-6">
							<img class="card-img-top border-no-radius" ng-if="list.m1_poster_path != null" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m1_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
						</div>
						<div class="col-6">
							<img class="card-img-top border-no-radius" ng-if="list.m2_poster_path != null" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m2_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
						</div>
						<div class="col-6">
							<img class="card-img-top border-no-radius" ng-if="list.m3_poster_path != null" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m3_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
						</div>
						<div class="col-6">
							<img class="card-img-top border-no-radius" ng-if="list.m4_poster_path != null" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m4_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
						</div>
						<div class="col-6">
							<img class="card-img-top border-no-radius" ng-if="list.m5_poster_path != null" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m5_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
						</div>
						<div class="col-6">
							<img class="card-img-top border-no-radius" ng-if="list.m6_poster_path != null" ng-src="{{config('constants.image.thumb_nail')[0]}}@{{list.m6_poster_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
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
						<div class="d-flex flex-row justify-content-center">
							<div class="text-white">
								<span class="d-block"><span class="h5 text-warning">35</span> <small>beğeni</small></span>
								
							</div>
						</div>
					</div>
					<!--<div class="p-2 text-right moviecard-percent">
						<div><span class="badge btn-verydark text-white">44</span></div>
					</div>-->
					<div class="p-2 text-right moviecard-rating">
						<div><span class="badge btn-verydark text-white">35</span></div>
					</div>
				</div>
				<div class="card-block">
					<h6 class="card-title px-1 py-1 my-0 text-dark text-left">İzlerken Aklınızı Başınızdan Alacak 32 Muhteşem Film <small class="text-muted d-block pt-1"><em>(5 saat önce)</em></small></h6>
				</div>
			</a>
		</div>
	</div>

</div>







