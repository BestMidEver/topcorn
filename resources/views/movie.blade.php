@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_movie')

@section('body')
<!--Trailer Section-->
<div class="mt-md-4">
	<div class="position-relative">
		<div id="accordion">
			<div>
				<div id="collapseCover" class="collapse show">
					<img ng-src="{{config('constants.image.cover')[$image_quality]}}@{{movie.backdrop_path}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid trailercover" alt="Responsive image">
					<div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
						<div class="d-flex flex-row p-2">
							<span class="text-white h6 lead lead-small">@{{movie.tagline}}</span>
						</div>
						<div class="d-flex flex-row justify-content-center" ng-if="movie.videos.results.length > 0">
							<button class="btn btn-link text-white btn-lg" ng-click="isfragman=true;scroll_to_top()" data-toggle="collapse" data-parent="#accordion" data-target="#collapseFragman" aria-expanded="false" aria-controls="collapseFragman"><i class="far fa-play-circle mr-2" aria-hidden="true"></i><small>{{ __('general.trailer') }}</small></button>
						</div>
						<div class="d-flex flex-row justify-content-end p-2 text-right">
							<div ng-if="movie.vote_average > 0">
								<div><span class="text-warning display-4 h6">@{{movie.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
								<div><span class="text-white"><small>@{{movie.vote_count}}</small></span><span class="text-white"> <small><span ng-if="movie.vote_count == 1">{{ __('general.person_time') }}</span><span ng-if="movie.vote_count > 1">{{ __('general.person_times') }}</span></small></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div id="collapseFragman" class="collapse" ng-if="movie.videos.results.length > 0">
					<div class="d-flex flex-row background-black pl-2 pt-2 pb-3">
						<span class="text-white h6 lead lead-small">@{{movie.tagline}}</span>
					</div>
					<div class="embed-responsive embed-responsive-1by1 trailer">
						<iframe class="embed-responsive-item" ng-src="@{{trailerurl}}" allowfullscreen></iframe>
					</div>
					<div class="d-flex flex-row background-black no-gutters">
						<div class="col">
							<div class="h-100 d-flex flex-column justify-content-center pl-2">
								<div ng-if="movie.videos.results.length > 1">
									<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == 0" ng-click="previous_trailer();"><i class="fa fa-step-backward" aria-hidden="true"></i></button>
									<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="current_trailer == movie.videos.results.length-1" ng-click="next_trailer();"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="h-100 d-flex flex-column justify-content-center text-center">
								<div>
									<button class="btn btn-outline-secondary border-0 btn-lg fa40 text-muted hover-white" ng-click="isfragman = false" data-toggle="collapse" data-parent="#accordion" data-target="#collapseCover" aria-expanded="true" aria-controls="accordion"><i class="fa fa-angle-up" aria-hidden="true"></i></button>
								</div>
							</div>
						</div>
						<div class="col pb-2 pr-2 text-right">
							<div ng-if="movie.vote_average > 0">
								<div><span class="text-warning display-4 h6">@{{movie.vote_average}}</span><span class="text-white"> <small>/10</small></span></div>
								<div><span class="text-white"><small>@{{movie.vote_count}}</small></span><span class="text-white"> <small><span ng-if="movie.vote_count == 1">{{ __('general.person_time') }}</span><span ng-if="movie.vote_count > 1">{{ __('general.person_times') }}</span></small></span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Trailer Section-->

<!--Under Trailer Section-->
<div class="d-flex flex-wrap justify-content-between">
	<div>
		<div class="d-flex flex-column">
			<div class="px-3 px-md-0"><a class="text-dark" ng-href="http://www.google.com/search?q=@{{movie.title+' '+movie.release_date.substring(0, 4)}}" target="_blank"><h1 class="h4 py-2">@{{movie.title}}</h1></a></div>
		</div>
	</div>
	@if(Auth::check())
	<div class="d-flex flex-column mt-1 mt-md-1 px-0 col-12 col-md-auto fa22 ml-auto">
		<div class="d-flex flex-row justify-content-between">
			<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addlater" ng-class="{'text-warning':user_movie_record.later_id!=null}" ng-click="this_later()"><i class="fa fa-clock-o d-block" aria-hidden="true"></i>{{ __('general.watch_later') }}</button>
			<button type="button" class="btn btn-sm btn-block border-0 mt-0 px-lg-4 addseen" ng-class="rate_class(user_movie_record.rate_code)" ng-click="this_votemodal()"><i class="fa fa-star-half-o d-block" aria-hidden="true"></i>{{ __('general.seen') }}</button>
			<button type="button" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addban" ng-class="{'text-danger':user_movie_record.ban_id!=null}" ng-click="this_ban()"><i class="fa fa-ban d-block" aria-hidden="true"></i>{{ __('general.ban') }}</button>
			<a href="{{config('constants.facebook.share_website')}}" target="_blank" class="btn btn-outline-secondary btn-sm btn-block border-0 mt-0 px-lg-4 addfacebook"><i class="fa fa-facebook-official d-block" aria-hidden="true"></i>{{ __('general.share') }}</a>
		</div>
	</div>
	@endif
</div>
<!--Under Trailer Section-->

<!--Poster Plot Details Section-->
<div class="row no-gutters mt-3 mt-md-5">
	<div class="col-12 col-md-3 col-lg-3">
		<img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top" alt="Responsive image">
	</div>
	<div class="col-12 col-md-9 col-lg-6">
		<div class="container-fluid">
			<p class="h6 pt-3 pt-md-0">@{{movie.release_date.substring(0, 4)}} <span class="text-muted" ng-if="movie.genres.length > 0">•</span> <span ng-repeat="genre in movie.genres"><span ng-if="$index!=0">, </span>@{{genre.name}}</span></p>
			<div class="pt-2" ng-if="movie.overview.length > 0 && movie.overview != 'No overview found.'"<p>@{{movie.overview}}</p></div>
			<div ng-if="directors.length > 0">
				<div class="h6 pt-1"><span ng-if="directors.length == 1">{{ __('general.director') }}</span><span ng-if="directors.length > 1">{{ __('general.directors') }}</span></div>
				<p><span class="d-inline" ng-repeat="director in directors"><span ng-if="$index!=0">, </span><a href="/person/@{{director.id}}" target={{$target}} class="text-dark">@{{director.name}}</a></span></p>
			</div>
			<div ng-if="writers.length > 0">
				<div class="h6 pt-1"><span ng-if="writers.length == 1">{{ __('general.writer') }}</span><span ng-if="writers.length > 1">{{ __('general.writers') }}</span></div>
				<p><span class="d-inline" ng-repeat="writer in writers"><span ng-if="$index!=0">, </span><a href="/person/@{{writer.id}}" target={{$target}} class="text-dark nowrap">@{{writer.name}}</a> @{{'(' + writer.job +')'}}</span></p>
			</div>
		</div>
	</div>
	<div class="col-3 d-none d-md-inline d-lg-none"></div>
	<div class="col-9 col-lg-3">
		<div class="container-fluid">
			<div class="h5 d-none d-lg-inline">{{ __('general.movie_details') }}</div>
			<div ng-if="movie.original_title.length > 0">
				<div class="h6 pt-2">{{ __('general.original_title') }}</div>
				<a class="text-dark" ng-href="http://www.google.com/search?q=@{{movie.original_title+' '+movie.release_date.substring(0, 4)}}" target="_blank"><p>@{{movie.original_title}}</p></a>
			</div>
			<div ng-if="secondary_title.length > 0">
				<div class="h6 pt-1">@{{secondary_language}} {{ __('general.its_title') }}</div>
				<a class="text-dark" ng-href="http://www.google.com/search?q=@{{secondary_title+' '+movie.release_date.substring(0, 4)}}" target="_blank"><p>@{{secondary_title}}</p></a>
			</div>
			<div ng-if="movie.original_language.length > 0">
				<div class="h6 pt-1">{{ __('general.original_language') }}</div>
				<p>@{{movie.original_language}}</p>
			</div>
			<div ng-if="movie.production_countries.length > 0">
				<div class="h6 pt-1"><span ng-if="movie.production_countries.length == 1">{{ __('general.producer_country') }}</span><span ng-if="movie.production_countries.length > 1">{{ __('general.producer_countries') }}</span></span></div>
				<p><span ng-repeat="country in movie.production_countries"><span ng-if="$index!=0">, </span>@{{country.name}}</span></p>
			</div>
			<div ng-if="movie.runtime > 0">
				<div class="h6 pt-1">{{ __('general.runtime') }}</div>
				<p>@{{movie.runtime}} {{ __('general.minute') }} <small class="text-muted">(@{{fancyruntime.hour}}{{ __('general.h') }} @{{fancyruntime.minute}}{{ __('general.m') }})</small></p>
			</div>
			<div ng-if="movie.budget > 0 && movie.budget != 0">
				<div class="h6 pt-1">{{ __('general.budget') }}</div>
				<p>$@{{fancybudget}}.00</p>
			</div>
			<div ng-if="movie.revenue > 0 && movie.revenue != 0">
				<div class="h6 pt-1">{{ __('general.revenue') }}</div>
				<p>$@{{fancyrevenue}}.00</p>
			</div>
			<div ng-if="movie.homepage.length > 0">
				<div class="h6 pt-1">{{ __('general.official_website') }}</div>
				<a ng-href="@{{movie.homepage}}" target="_blank" class="text-dark break-word"><p><i class="fa fa-external-link" aria-hidden="true"></i> @{{movie.homepage}}</p></a>
			</div>
			<div ng-if="movie.belongs_to_collection">
				<div class="h6 pt-1">@{{movie.belongs_to_collection.name}}</div>
				<div ng-repeat="c in collection"><a ng-href="/movie/@{{c.id}}" target={{$target}} class="text-dark">@{{c.title + (c.release_date ? ' (' + c.release_date.substring(0, 4) + ')' : '') }}</a></div>
			</div>
		</div>
	</div>
</div>
<!--Poster Plot Details Section-->

<!--Cast Section-->
<div class="container-fluid px-0 mt-5" id="cast" ng-if="movie.credits.cast.length > 0">
	<div class="px-3 px-md-0"><div class="h5">{{ __('general.actors') }}</div></div>
	<div class="">
		<div class="d-flex flex-wrap">
			<div class="col-4 col-lg-2 mt-2 px-1" ng-repeat="person in movie.credits.cast | limitTo:6">
				<div class="card moviecard h-100 d-flex flex-column justify-content-between">
					<a href="/person/@{{person.id}}" target={{$target}}>
						<img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						<div class="card-block text-center">
							<h6 class="card-title px-1 pt-1 text-dark">@{{person.name}}</h6>
						</div>
					</a>
					<div class="card-title px-1 text-muted text-center mb-0"><small>@{{person.character}}</small></div>
				</div>
			</div>
		</div>
	</div>
	<div class="collapse" id="collapseCast" ng-if="movie.credits.cast.length > 6">
		<div class="d-flex flex-wrap">
			<div class="col-4 col-lg-2 mt-2 px-1" ng-repeat="person in movie.credits.cast | limitTo:100:6">
				<div class="card moviecard h-100 d-flex flex-column justify-content-between">
					<a href="/person/@{{person.id}}" target={{$target}}>
						<img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
						<div class="card-block text-center">
							<h6 class="card-title px-1 pt-1 text-dark" ng-if="person.name.length > 0">@{{person.name}}</h6>
						</div>
					</a>
					<div class="card-title px-1 text-muted text-center mb-0"><small ng-if="person.character.length > 0">@{{person.character}}</small></div>
				</div>
			</div>
		</div>
	</div>
	<div ng-if="movie.credits.cast.length > 6">
		<div class="text-center pt-1" ng-hide="iscast">
			<button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast = true; scroll_to_cast()" data-toggle="collapse" data-target="#collapseCast"><small>{{ __('general.show_everyone') }}</small></button>
		</div>
		<div class="text-center pt-1" ng-show="iscast">
			<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast = false; scroll_to_cast()" data-toggle="collapse" data-target="#collapseCast"><i class="fa fa-angle-up" aria-hidden="true"></i></button>
		</div>
	</div>
</div>
<!--Cast Section-->

<!--Review Section-->
<div class="container-fluid mt-5">	
	<div>
		<span class="h5 mb-0 pr-2">{{ __('general.reviews') }}</span>
		<a href="https://www.themoviedb.org/movie/{{$id}}/reviews" class="btn btn-outline-success btn-sm" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i> {{ __('general.add_review') }}</a>
	</div>
	<div ng-if="movie.reviews.results.length>0" class="py-4" ng-repeat="review in movie.reviews.results">
		<div class="h6 pb-2">@{{review.author}}</div>
		<div id="@{{'accordion'+$index}}">
			<div ng-if="review.id == 'long'">
				<div id="@{{'collapse'+$index+'a'}}" class="lead lead-small collapse">
					<div>
						<div ng-bind-html="review.content"></div>
					</div>
					<div class="text-center pt-0">
						<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white hidereview" data-toggle="collapse" data-parent="@{{'#accordion'+$index}}" data-target="@{{'#collapse'+$index+'b'}}"><i class="fa fa-angle-up" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
			<div>
				<div id="@{{'collapse'+$index+'b'}}" class="lead lead-small collapse show">
					<div>
						<div ng-bind-html="review.url"></div>
					</div>
					<div ng-if="review.id == 'long'">
						<div class="text-center pt-1">
							<button class="btn btn-outline-secondary border-0 text-muted hover-white showreview" data-toggle="collapse" data-parent="@{{'#accordion'+$index}}" data-target="@{{'#collapse'+$index+'a'}}"><small>{{ __('general.read_all') }}</small></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="p-5" ng-if="!movie.reviews.results.length>0">
		<div class="text-muted text-center">{{ __('general.no_result_review') }}</div>
	</div>
</div>
<!--Review Section-->

@include('layout.this_ratemodal')

@endsection