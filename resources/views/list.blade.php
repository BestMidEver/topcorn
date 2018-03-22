@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h4 text-center text-md-left col mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="text-muted col"><small>5 ay önce eklendi, en son 23 gün önce güncellendi.</small></div>

<div class="col mt-2">
	<a href="#">
		<img src="https://graph.facebook.com/v2.10/10211736611553891/picture?type=normal" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="list-thumbnail" alt="Responsive image">
		<span class="text-dark">Szofijjja</span>
	</a>
</div>

<div class="container-fluid mt-3">



	<div class="mt-md-4">
		<div class="position-relative">
			<div id="accordion">
				<div>
					<div id="collapseCover" class="collapse show" data-parent="#accordion">
						<img ng-src="https://image.tmdb.org/t/p/w1280/2gJDuPxrZBns5ab47HQbyU2l6Im.jpg" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid trailercover" alt="Responsive image">
						<div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
							<div class="d-flex flex-row no-gutters">
								<div class="col pt-2 pl-2">
									<span class="text-white h6 lead lead-small">1. Elveda Las Vegas (1995)</span>
								</div>
								<div class="col p-2 text-right">
									<!--
									<div ng-if="user_movie_record.percent > 0">
										<small class="text-white">{{ __("general.according_to_your_taste") }}</small>
										<div>
											<span class="text-warning display-4 d-none d-md-inline">%@{{user_movie_record.percent}}</span><span class="text-warning h5 d-md-none">%@{{user_movie_record.percent}}</span><span class="text-white"> <small>{{ __("general.match") }}</small></span>
										</div>
										@if(Auth::check())
											@if(Auth::User()->advanced_filter)
										<div>
											<span class="text-white"><small>@{{user_movie_record.point*1+user_movie_record.p2*1}}/@{{user_movie_record.p2*2}}</small></span><span class="text-white"> <small>{{ __("general.point") }}</small></span>
										</div>
											@endif
										@endif
									</div>
									-->
								</div>
							</div>
							<div class="d-flex flex-row justify-content-center" ng-if="1 > 0">
								<button class="btn btn-link text-white btn-lg" ng-click="isfragman=true;" data-toggle="collapse" data-target="#collapseFragman" aria-expanded="false" aria-controls="collapseFragman"><i class="far fa-play-circle mr-2"></i><small>{{ __('general.trailer') }}</small></button>
							</div>
							<div class="d-flex flex-row justify-content-end p-2 text-right">
								<!--
								<div ng-if="movie.vote_average > 0">
									<div><span class="text-warning display-4 d-none d-md-inline">@{{movie.vote_average}}</span><span class="text-warning h5 d-md-none">@{{movie.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
									<div><span class="text-white"><small>@{{movie.vote_count}}</small></span><span class="text-white"> <small><span ng-if="movie.vote_count == 1">{{ __('general.person_time') }}</span><span ng-if="movie.vote_count > 1">{{ __('general.person_times') }}</span></small></span></div>
								</div>
								-->
							</div>
						</div>
					</div>
				</div>
				<div>
					<div id="collapseFragman" class="collapse" data-parent="#accordion" ng-if="1 > 0">
						<div class="d-flex flex-row background-black no-gutters pl-2 pt-2 pb-3">
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center pl-2">
									<span class="text-white h6 lead lead-small">1. Elveda Las Vegas (1995)</span>
								</div>
							</div>
							<div class="col pb-2 pr-2 text-right">
								<!--
								<div ng-if="user_movie_record.percent > 0">
									<div>
										<small class="text-white">{{ __("general.according_to_your_taste") }} </small><span class="text-warning h4 d-none d-md-inline">%@{{user_movie_record.percent}}</span><span class="text-warning h5 d-md-none">%@{{user_movie_record.percent}}</span><span class="text-white"> <small>{{ __("general.match") }}</small></span>
									</div>
									@if(Auth::check())
										@if(Auth::User()->advanced_filter)
									<div>
										<span class="text-white"><small>@{{user_movie_record.point*1+user_movie_record.p2*1}}/@{{user_movie_record.p2*2}}</small></span><span class="text-white"> <small>{{ __("general.point") }}</small></span>
										</div>
										@endif
									@endif
								</div>
								-->
							</div>
						</div>
						<div class="embed-responsive embed-responsive-1by1 listtrailer">
							<iframe class="embed-responsive-item" ng-src="https://www.youtube.com/embed/UMlYWZgCIgo" allowfullscreen></iframe>
						</div>
						<div class="d-flex flex-row background-black no-gutters">
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center pl-2">
									<div ng-if="2 > 1">
										<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="false" ng-click="previous_trailer();"><i class="fa fa-step-backward"></i></button>
										<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="false" ng-click="next_trailer();"><i class="fa fa-step-forward"></i></button>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center text-center">
									<div>
										<button class="btn btn-outline-secondary border-0 btn-lg fa40 text-muted hover-white" ng-click="isfragman = false" data-toggle="collapse" data-target="#collapseCover" aria-expanded="true" aria-controls="collapseCover"><i class="fa fa-angle-up"></i></button>
									</div>
								</div>
							</div>
							<div class="col pb-2 pr-2 text-right">
								<!--
								<div ng-if="movie.vote_average > 0">
									<div><span class="text-warning h4 d-none d-md-inline">@{{movie.vote_average}}</span><span class="text-warning h5 d-md-none">@{{movie.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
									<div><span class="text-white"><small>@{{movie.vote_count}}</small></span><span class="text-white"> <small><span ng-if="movie.vote_count == 1">{{ __('general.person_time') }}</span><span ng-if="movie.vote_count > 1">{{ __('general.person_times') }}</span></small></span></div>
								</div>
								-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>





</div>
@endsection