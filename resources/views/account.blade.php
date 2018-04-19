@extends('layout.app')

@include('head.head_account')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.account') }}</h5>

<div class="container-fluid mt-3 pb-1">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<a class="nav-link active text-muted" href="/account">{{ __('general.profile') }}</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account/password">{{ __('general.password') }}</a>
		</li>
		<li class="nav-item mb-2">
			<a class="nav-link text-muted" href="/account/interface">{{ __('general.interface') }}</a>
		</li>
	</ul>
</div>
@if(session()->has('status'))
    <div class="alert alert-success"> 
    {!! session('status') !!}
    </div>
@endif
<div class="position-relative pt-1">
	<img ng-src="@{{cover_src}}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
	<div class="coveroverlayersmall d-md-none">
		<div class="d-flex flex-column align-items-center">
			<div class="d-flex flex-column">
				<div class="d-flex flex-row align-items-center">
					<div class="d-flex flex-column">
						<img ng-src="@{{profile_src}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicsmall" alt="Responsive image">
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex flex-row align-items-center ml-2">
							<h5><span class="yeswrap text-left text-light">{{ Auth::user()->name }}</span></h5>
						</div>
						<div class="d-flex flex-row align-items-center text-light ml-2">
							@if($watched_movie_number > 0)
							<div data-toggle="tooltip" data-placement="top" title="{{ __('general.watched_movie_number') }}">
								<i class="fas fa-check"></i><div class="d-inline pl-1" >{{ $watched_movie_number }}</div>
							</div>
							@endif
							@if($list_number > 0)
							<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.list_number') }}">
								<i class="fas fa-plus"></i><div class="d-inline pl-1" >{{ $list_number }}</div>
							</div>
							@endif
							@if($like_number > 0)
							<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.like_number') }}">
								<i class="fas fa-heart"></i><div class="d-inline pl-1" >{{ $like_number }}</div>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="coveroverlayermedium d-none d-md-inline">
		<div class="d-flex flex-column">
			<div class="d-flex flex-row align-items-center">
				<div class="d-flex flex-column">
					<img ng-src="@{{profile_src}}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicmedium" alt="Responsive image">
				</div>
				<div class="d-flex flex-column">
					<div class="d-flex flex-row align-items-center ml-2">
						<h5><span class="yeswrap text-left text-light">{{ Auth::user()->name }}</span></h5>
					</div>
					<div class="d-flex flex-row align-items-center text-light ml-2">
							@if($watched_movie_number > 0)
							<div data-toggle="tooltip" data-placement="top" title="{{ __('general.watched_movie_number') }}">
								<i class="fas fa-check"></i><div class="d-inline pl-1" >{{ $watched_movie_number }}</div>
							</div>
							@endif
							@if($list_number > 0)
							<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.list_number') }}">
								<i class="fas fa-plus"></i><div class="d-inline pl-1" >{{ $list_number }}</div>
							</div>
							@endif
							@if($like_number > 0)
							<div class="pl-3" data-toggle="tooltip" data-placement="top" title="{{ __('general.like_number') }}">
								<i class="fas fa-heart"></i><div class="d-inline pl-1" >{{ $like_number }}</div>
							</div>
							@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col"></div>
		<div class="col-12 col-xl-10">
			<form id="the_form" class="form-horizontal" role="form" method="POST" action="/account">
				{{ csrf_field() }}
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">{{ __('general.user_name') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-user"></i></div>
				                </div>
				                <input type="text" class="form-control" id="name" ng-value="'{{  Auth::User()->name }}'" ng-model="user_name" ng-change="check_save_disabled()" name="name" required autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
				            </div>
				        </div>
				    </div>
				    <div class="col-md-3">
				        <div class="form-control-feedback">
				            @if ($errors->has('name'))
				                <span class="text-danger align-middle float-right float-md-none">
				                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('name') }}
				                </span>
				            @endif
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="image_quality" ng-mouseenter="hovering_cove=true" ng-mouseleave="hovering_cove=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_cover_photo') }}">{{ __('general.cover_photo') }} <span ng-show="!hovering_cove"><i class="far fa-question-circle"></i></span><span ng-show="hovering_cove"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="far fa-image"></i></div>
				                </div>
				                <select class="form-control" id="cover_pic" name="cover_pic" ng-change="choose_cover()" ng-model="cover_path" ng-init="cover_path=''">
									<option ng-repeat="c in cover_movies" ng-value="c.cover_path">@{{c.title}}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="image_quality" ng-mouseenter="hovering_prof=true" ng-mouseleave="hovering_prof=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_profile_pic') }}">{{ __('general.profile_photo') }} <span ng-show="!hovering_prof"><i class="far fa-question-circle"></i></span><span ng-show="hovering_prof"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="far fa-image"></i></div>
				                </div>
				                <select class="form-control" id="profile_pic" name="profile_pic" ng-change="choose_profile()" ng-model="profile_path" ng-init="profile_path=''" ng-disabled="is_searching">
				                	<option ng-value="profile_path_selected_value" ng-hide="true">@{{profile_path_selected_text}}</option>
				                	@if(Auth::user()->facebook_profile_pic)
				                	<option ng-value="[0,'Facebook Profil Fotoğrafı']" ng-hide="p.profile_path == 0">{{ __('general.facebook_profile_photo') }}</option>
				                	@endif
				                	<option ng-repeat="p in profile_actors" ng-value="[p.profile_path,p.name]">@{{p.name}}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>

@if(1)
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">{{ __('general.links') }}</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">Facebook</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text">https://www.facebook.com/</div>
				                </div>
				                <input type="text" class="form-control" id="name" ng-value="'{{  Auth::User()->name }}'" ng-model="user_name" ng-change="check_save_disabled()" name="name">
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">Twitter</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text">https://twitter.com/</div>
				                </div>
				                <input type="text" class="form-control" id="name" ng-value="'{{  Auth::User()->name }}'" ng-model="user_name" ng-change="check_save_disabled()" name="name">
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">Instagram</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text">https://www.instagram.com/</div>
				                </div>
				                <input type="text" class="form-control" id="name" ng-value="'{{  Auth::User()->name }}'" ng-model="user_name" ng-change="check_save_disabled()" name="name">
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">Youtube</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text">https://www.youtube.com/channel/</div>
				                </div>
				                <input type="text" class="form-control" id="name" ng-value="'{{  Auth::User()->name }}'" ng-model="user_name" ng-change="check_save_disabled()" name="name">
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive pt-0">
		                <input type="text" class="form-control text-right" id="another_link" ng-value="" ng-model="user_name" ng-change="check_save_disabled()" name="another_link" placeholder="{{ __('general.another_link') }}">
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text"><i class="fas fa-link"></i></div>
				                </div>
				                <input type="text" class="form-control" id="name" ng-value="'{{  Auth::User()->name }}'" ng-model="user_name" ng-change="check_save_disabled()" name="name">
				            </div>
				        </div>
				    </div>
				</div>
@endif
				<div class="row mt-3">
				    <div class="col-md-3"></div>
				    <div class="col-md-6">
				        <button type="submit" class="btn btn-primary btn-block" ng-disabled="is_save_disabled">{{ __('general.save_changes') }}</button>
				    </div>
				</div>
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection