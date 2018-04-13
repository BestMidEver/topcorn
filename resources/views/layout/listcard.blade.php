<div ng-if="active_tab == 'get_lists'">
	















	<div class="card py-2 px-0">
		<a href="#">
			<div class="h6 text-dark px-2">İzlerken Aklınızı Başınızdan Alacak 32 Muhteşem Film <small class="text-muted d-block pt-1"><em>(5 saat önce)</em></small></div>
		</a>
		<div class="row">
			<div class="col"></div>
				<div class="col-4 card-group no-gutters">
					<div class="col-4">
						<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/fQMSaP88cf1nz4qwuNEEFtazuDM.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					</div>
					<div class="col-4">
						<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/wShp6RwmmC5V6uhz9X0zMfs4740.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					</div>
					<div class="col-4">
						<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/aTG2EvePwRx34MwCg70Q20INzQM.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					</div>
					<div class="col-4">
						<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/ybQLA0vUHFCPsnuJ6rCRev9YFcV.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					</div>
					<div class="col-4">
						<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/g8qWglC2XXCIN8P51eCljFvCNNJ.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					</div>
					<div class="col-4">
						<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/gornum2ob13CQrYt1SjfnnLhkUQ.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
					</div>
				</div>
			<div class="col"></div>
		</div>
		<div class="text-muted text-right px-2"><small>2 gün önce ekledi, en son 5 saat önce güncelledi.</small></div>
	</div>




<div class="card-group no-gutters">
	<div class="col-6 col-md-6 col-lg-4 col-xl-4 mt-4">
		<div class="card moviecard h-100 d-flex flex-column justify-content-between mx-2">
			<a href="#" target={{$target}}>
				<div class="position-relative text-center">
					<div class="card-group no-gutters">
						<div class="col-4">
							<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/fQMSaP88cf1nz4qwuNEEFtazuDM.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						</div>
						<div class="col-4">
							<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/wShp6RwmmC5V6uhz9X0zMfs4740.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						</div>
						<div class="col-4">
							<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/aTG2EvePwRx34MwCg70Q20INzQM.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						</div>
						<div class="col-4">
							<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/ybQLA0vUHFCPsnuJ6rCRev9YFcV.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						</div>
						<div class="col-4">
							<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/g8qWglC2XXCIN8P51eCljFvCNNJ.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						</div>
						<div class="col-4">
							<img class="card-img-top border-no-radius" ng-src="https://image.tmdb.org/t/p/w100_and_h100_bestv2/gornum2ob13CQrYt1SjfnnLhkUQ.jpg" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						</div>
					</div>
					<!--<div class="custom-over-layer h-50 d-flex flex-column justify-content-center">
						<div class="d-flex flex-row justify-content-center" ng-if="movie.percent > 0">
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
					<div class="p-2 text-right moviecard-percent">
						<div><span class="badge btn-verydark text-white">44</span></div>
					</div>
					<div class="p-2 text-right moviecard-rating">
						<div><span class="badge btn-verydark text-white">12</span></div>
					</div>-->
				</div>
				<div class="card-block">
					<h6 class="card-title px-1 py-1 my-0 text-dark text-left">İzlerken Aklınızı Başınızdan Alacak 32 Muhteşem Film <small class="text-muted d-block pt-1"><em>(5 saat önce)</em></small></h6>
				</div>
			</a>
		</div>
	</div>
</div>
















</div>