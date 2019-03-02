<div class="d-flex flex-wrap">
	<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in users{{ $suffix }} | limitTo:6">
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
<div class="collapse" id="collapseMovies{{ $suffix }}">
	<div ng-if="users{{ $suffix }}.length > 6">
		<div class="d-flex flex-wrap">
        	<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in users{{ $suffix }} | limitTo:100:6">
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
    </div>
</div>
<div ng-show="iscast{{  $suffix  }}">
@include('layout.pagination', ['suffix' => '_'.$suffix])
</div>
<div class="text-center pt-1" ng-hide="iscast{{ $suffix }} || !(users{{ $suffix }}.length>6)">
    <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast{{ $suffix }} = true;" data-toggle="collapse" data-target="#collapseMovies{{ $suffix }}"><small>{{__('general.show_all')}}</small></button>
</div>
<div class="text-center pt-1" ng-show="iscast{{ $suffix }} && users{{ $suffix }}.length>6">
    <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast{{ $suffix }} = false;" data-toggle="collapse" data-target="#collapseMovies{{ $suffix }}"><i class="fa fa-angle-up"></i></button>
</div>