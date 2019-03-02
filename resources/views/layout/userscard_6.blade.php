<div class="" id="cast{{  $suffix  }}" ng-if="users.length > 0">
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
					<!-- <div class="card-title px-1 text-muted text-center mb-0"><small>@{{person.character}}</small></div> -->
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
		<div class="text-center pt-1" ng-hide="iscast{{  $suffix  }}">
			<button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast{{  $suffix  }} = true;" data-toggle="collapse" data-target="#collapseCast{{  $suffix  }}"><small>{{ __('general.show_everyone') }}</small></button>
		</div>
		<div class="text-center pt-1" ng-show="iscast{{  $suffix  }}">
			<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast{{  $suffix  }} = false;" data-toggle="collapse" data-target="#collapseCast{{  $suffix  }}"><i class="fa fa-angle-up"></i></button>
		</div>
	</div>
</div>




<div id="cast{{  $suffix  }}" ng-if="users4.length > 0">
	<div class="d-flex flex-wrap">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in users4 | limitTo:6">
			<div class="card moviecard h-100 d-flex flex-column justify-content-between">
				<a ng-href="/profile/@{{ user.user_id }}" target={{$target}}>
					<img class="card-img-top" ng-src="@{{user.profile_path == null || user.profile_path == '' ? user.facebook_profile_path : constants_image_thumb_nail + user.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					<div class="card-block">
						<h6 class="card-title px-1 pt-1 text-muted text-center">@{{user.name}}</h6>
					</div>
				</a>
				<div class="card-footer p-0">
					<div class="row no-gutters">
						<div class="col">
							<a class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'disabled':user.user_id == user_id}" ng-href="/recommendations/@{{user.user_id}}"><i class="fa fa-plus" aria-hidden="true" disabled></i> {{ __('general.watch_together') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="d-flex flex-wrap" class="collapse" id="collapseCast{{  $suffix  }}">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in users4 | limitTo:100:6">
			<div class="card moviecard h-100 d-flex flex-column justify-content-between">
				<a ng-href="/profile/@{{ user.user_id }}" target={{$target}}>
					<img class="card-img-top" ng-src="@{{user.profile_path == null || user.profile_path == '' ? user.facebook_profile_path : constants_image_thumb_nail + user.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
					<div class="card-block">
						<h6 class="card-title px-1 pt-1 text-muted text-center">@{{user.name}}</h6>
					</div>
				</a>
				<div class="card-footer p-0">
					<div class="row no-gutters">
						<div class="col">
							<a class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'disabled':user.user_id == user_id}" ng-href="/recommendations/@{{user.user_id}}"><i class="fa fa-plus" aria-hidden="true" disabled></i> {{ __('general.watch_together') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div ng-show="iscast{{  $suffix  }}">
	@include('layout.pagination', ['suffix' => '_'.$suffix])
	</div>
	<div ng-show="people{{  $suffix  }}.length > 6">
		<div class="text-center pt-1" ng-hide="iscast{{  $suffix  }}">
			<button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast{{  $suffix  }} = true;" data-toggle="collapse" data-target="#collapseCast{{  $suffix  }}"><small>{{ __('general.show_everyone') }}</small></button>
		</div>
		<div class="text-center pt-1" ng-show="iscast{{  $suffix  }}">
			<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast{{  $suffix  }} = false;" data-toggle="collapse" data-target="#collapseCast{{  $suffix  }}"><i class="fa fa-angle-up"></i></button>
		</div>
	</div>
</div>