<div class="" id="cast{{  $suffix  }}" ng-if="people{{  $suffix  }}.length > 0">
	<div class="">
		<div class="d-flex flex-wrap">
			<div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in people{{  $suffix  }} | limitTo:6">
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
	<div class="collapse" id="collapseCast{{  $suffix  }}">
		<div ng-if="people{{  $suffix  }}.length > 6">
			<div class="d-flex flex-wrap">
				<div class="col-4 col-md-2 mt-4 px-2" ng-repeat="person in people{{  $suffix  }} | limitTo:100:6">
					<div class="card moviecard h-100 d-flex flex-column justify-content-between">
						<a href="/person/@{{person.id}}" target={{$target}}>
							<img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
							<div class="card-block text-center">
								<h6 class="card-title px-1 pt-1 text-dark" ng-if="person.name.length > 0">@{{person.name}}</h6>
							</div>
						</a>
						<!-- <div class="card-title px-1 text-muted text-center mb-0"><small ng-if="person.character.length > 0">@{{person.character}}</small></div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div ng-show="iscast{{  $suffix  }}">
	@include('layout.pagination', ['suffix' => '_'.$suffix])
	</div>
	<div ng-show="people{{  $suffix  }}.length > 6">
		<div class="text-center pt-1" ng-hide="iscast{{  $suffix  }} || is_expanded{{ $suffix }}">
			<button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast{{  $suffix  }} = true;" data-toggle="collapse" data-target="#collapseCast{{  $suffix  }}"><small>{{ __('general.show_everyone') }}</small></button>
		</div>
		<div class="text-center pt-1" ng-show="iscast{{  $suffix  }} && is_expanded{{ $suffix }}!=true">
			<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast{{  $suffix  }} = false;" data-toggle="collapse" data-target="#collapseCast{{  $suffix  }}"><i class="fa fa-angle-up"></i></button>
		</div>
	</div>
</div>
