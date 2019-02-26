@extends('layout.app')

@include('head.head_accountnotificationsemails')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.account') }}</h5>




<!-- Tabs Button -->
<div class="container-fluid mt-3 pb-1 d-none d-md-inline">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account">{{ __('general.profile') }}</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account/password">{{ __('general.password') }}</a>
		</li>
		<li class="nav-item mb-2">
			<a class="nav-link text-muted" href="/account/interface">{{ __('general.interface') }}</a>
		</li>
		<li class="nav-item mb-2">
			<a class="nav-link active text-muted" href="/account/notifications-emails">{{ __('general.notifications_emails') }}</a>
		</li>
	</ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu my-3 d-md-none tab2">
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" href="/account">{{ __('general.profile') }}</a>
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" href="/account/password">{{ __('general.password') }}</a>
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" href="/account/interface">{{ __('general.interface') }}</a>
	<a class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration active" href="/account/notifications-emails">{{ __('general.notifications_emails') }}</a>
</div>
<!-- Tabs Button Mobile -->




@if(session()->has('status'))
    <div class="alert alert-success">
    {!! session('status') !!}
    </div>
@endif
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col"></div>
		<div class="col-12 col-xl-10">
			<form id="the_form" class="form-horizontal" role="form" method="POST" action="/account/notifications-emails">
				{{ csrf_field() }}
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_system_change" ng-mouseenter="hovering_air=true" ng-mouseleave="hovering_air=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_when_system_change') }}">{{ __('general.when_system_change') }} <span ng-show="!hovering_air"><i class="far fa-question-circle"></i></span><span ng-show="hovering_air"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-clock"></i></div>
				                </div>
				                <select class="form-control" id="when_system_change" name="when_system_change">
									<option value="0" {{Auth::User()->when_system_change==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_system_change==1?'selected':''}}>{{ __('general.do_notification') }}</option>
									<option value="2" {{Auth::User()->when_system_change==2?'selected':''}}>{{ __('general.notification_and_email') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_automatic_notification" ng-mouseenter="hovering_tog=true" ng-mouseleave="hovering_tog=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_when_automatic_notification') }}">{{ __('general.when_automatic_notification') }} <span ng-show="!hovering_tog"><i class="far fa-question-circle"></i></span><span ng-show="hovering_tog"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-user-friends"></i></div>
				                </div>
				                <select class="form-control" id="when_automatic_notification" name="when_automatic_notification">
									<option value="0" {{Auth::User()->when_automatic_notification==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_automatic_notification==1?'selected':''}}>{{ __('general.do_notification') }}</option>
									<option value="2" {{Auth::User()->when_automatic_notification==2?'selected':''}}>{{ __('general.notification_and_email') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="when_user_interaction" ng-mouseenter="hovering_rec=true" ng-mouseleave="hovering_rec=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_when_user_interaction') }}">{{ __('general.when_user_interaction') }} <span ng-show="!hovering_rec"><i class="far fa-question-circle"></i></span><span ng-show="hovering_rec"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-share"></i></div>
				                </div>
				                <select class="form-control" id="when_user_interaction" name="when_user_interaction">
									<option value="0" {{Auth::User()->when_user_interaction==0?'selected':''}}>{{ __('general.dont_do_anything') }}</option>
									<option value="1" {{Auth::User()->when_user_interaction==1?'selected':''}}>{{ __('general.do_notification') }}</option>
									<option value="2" {{Auth::User()->when_user_interaction==2?'selected':''}}>{{ __('general.notification_and_email') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3"></div>
				    <div class="col-md-6">
				        <button type="submit" class="btn btn-primary btn-block">{{ __('general.save_changes') }}</button>
				    </div>
				</div>
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection