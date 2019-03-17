<div class="d-flex flex-wrap" ng-cloak>
	<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in users{{ $suffix }} | limitTo:6">
        <div class="card moviecard h-100 d-flex flex-column justify-content-between">
            <a ng-href="/profile/@{{ user.user_id }}#!#Lists" target={{$target}}>
                <div class="position-relative text-center min-height-200">
                    <img class="card-img-top darken-cover" ng-src="@{{user.profile_path == null || user.profile_path == '' ? user.facebook_profile_path : constants_image_thumb_nail + user.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
                    <div class="custom-over-layer h-50 d-flex flex-column justify-content-center">
                        <div class="d-flex flex-row justify-content-center">
                            <div class="text-white">
                                <small ng-if="page_variables.active_tab_4=='comment'"><span class="h5 text-warning">@{{user.count}}</span> <span ng-show="user.count==1">{{ __('general.like_count') }}</span><span ng-show="user.count>1">{{ __('general.like_counts') }}</span></small>
                                <small ng-if="page_variables.active_tab_4=='list'"><span class="h5 text-warning">@{{user.count}}</span> <span ng-show="user.count==1">{{ __('general.like_count') }}</span><span ng-show="user.count>1">{{ __('general.like_counts') }}</span></small>
                                <small ng-if="page_variables.active_tab_4=='follow'"><span class="h5 text-warning">@{{user.count}}</span> <span ng-show="user.count==1">{{ __('general.follower') }}</span><span ng-show="user.count>1">{{ __('general.follower_plural') }}</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <h6 class="card-title px-1 pt-1 text-muted text-center">@{{user.name}}</h6>
                    </div>
                </div>
            </a>
            @if(Auth::check())
            <div class="card-footer p-0">
                <div class="row no-gutters">
                    <div class="col">
                        <a class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'disabled':user.user_id == user_id}" ng-href="/recommendations/@{{user.user_id}}"><i class="fa fa-plus" aria-hidden="true" disabled></i> {{ __('general.watch_together') }}</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
	</div>
</div>
<div class="collapse" id="collapseMovies{{ $suffix }}" ng-cloak>
	<div ng-if="users{{ $suffix }}.length > 6">
		<div class="d-flex flex-wrap">
        	<div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-4 px-1" ng-repeat="user in users{{ $suffix }} | limitTo:100:6">
                <div class="card moviecard h-100 d-flex flex-column justify-content-between">
                    <a ng-href="/profile/@{{ user.user_id }}#!#Lists" target={{$target}}>
                        <div class="position-relative text-center min-height-200">
                            <img class="card-img-top darken-cover" ng-src="@{{user.profile_path == null || user.profile_path == '' ? user.facebook_profile_path : constants_image_thumb_nail + user.profile_path}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" alt="Card image cap">
                            <div class="custom-over-layer h-50 d-flex flex-column justify-content-center">
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="text-white">
                                        <small ng-if="page_variables.active_tab_4=='comment'"><span class="h5 text-warning">@{{user.count}}</span> <span ng-show="user.count==1">{{ __('general.like_count') }}</span><span ng-show="user.count>1">{{ __('general.like_counts') }}</span></small>
                                        <small ng-if="page_variables.active_tab_4=='list'"><span class="h5 text-warning">@{{user.count}}</span> <span ng-show="user.count==1">{{ __('general.like_count') }}</span><span ng-show="user.count>1">{{ __('general.like_counts') }}</span></small>
                                        <small ng-if="page_variables.active_tab_4=='follow'"><span class="h5 text-warning">@{{user.count}}</span> <span ng-show="user.count==1">{{ __('general.follower') }}</span><span ng-show="user.count>1">{{ __('general.follower_plural') }}</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <h6 class="card-title px-1 pt-1 text-muted text-center">@{{user.name}}</h6>
                            </div>
                        </div>
                    </a>
                    @if(Auth::check())
                    <div class="card-footer p-0">
                        <div class="row no-gutters">
                            <div class="col">
                                <a class="btn btn-outline-secondary btn-sm btn-block addlater border-0" ng-class="{'disabled':user.user_id == user_id}" ng-href="/recommendations/@{{user.user_id}}"><i class="fa fa-plus" aria-hidden="true" disabled></i> {{ __('general.watch_together') }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
        	</div>
        </div>
    </div>
</div>
<div ng-show="iscast{{  $suffix  }}" ng-cloak>
@include('layout.pagination', ['suffix' => '_'.$suffix])
</div>
<div class="text-center pt-1" ng-hide="iscast{{ $suffix }} || !(users{{ $suffix }}.length>6) || is_expanded{{ $suffix }}" ng-cloak>
    <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast{{ $suffix }} = true;" data-toggle="collapse" data-target="#collapseMovies{{ $suffix }}"><small>{{__('general.show_everyone')}}</small></button>
</div>
<div class="text-center pt-1" ng-show="iscast{{ $suffix }} && users{{ $suffix }}.length>6 && is_expanded{{ $suffix }}!=true" ng-cloak>
    <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast{{ $suffix }} = false;" data-toggle="collapse" data-target="#collapseMovies{{ $suffix }}"><i class="fa fa-angle-up"></i></button>
</div>