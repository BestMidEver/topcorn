@extends('layout.app')

@include('head.head_accountpassword')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.account') }}</h5>

<div class="container-fluid mt-3 pb-1">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account">{{ __('general.profile') }}</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active text-muted" href="/account/password">{{ __('general.password') }}</a>
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
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col"></div>
		<div class="col-12 col-xl-10">
			<form class="form-horizontal" role="form" method="POST" action="/account/password">
				{{ csrf_field() }}
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="email">{{ __('general.email') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-at"></i></div>
				                </div>
				                <input type="email" class="form-control" id="email" value="{{  Auth::User()->email }}" readonly>
				            </div>
				        </div>
				    </div>
				</div>
				@if (!$is_from_facebook)
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">{{ __('general.current_password') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-key"></i></div>
				                </div>
				                <input type="password" class="form-control" id="current_password" name="current_password" required autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
				            </div>
				        </div>
				    </div>
				    <div class="col-md-3">
				        <div class="form-control-feedback">
				            @if ($errors->has('current_password'))
				                <span class="text-danger align-middle float-right float-md-none">
				                    <i class="fa fa-close"> {{ $errors->first('current_password') }}</i>
				                </span>
				            @endif
				        </div>
				    </div>
				</div>
				@endif
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="new_password">{{ __('general.new_password') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-key"></i></div>
				                </div>
				                <input type="password" class="form-control" id="new_password" name="new_password" required>
				            </div>
				        </div>
				    </div>
				    <div class="col-md-3">
				        <div class="form-control-feedback">
				            @if ($errors->has('new_password'))
				                <span class="text-danger align-middle float-right float-md-none">
				                    <i class="fa fa-close"> {{ $errors->first('new_password') }}</i>
				                </span>
				            @endif
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="new_password_confirmation">{{ __('general.new_password_confirmation') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
				                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-md-3"></div>
				    <div class="col-md-6">
				        <button type="submit" class="btn btn-primary btn-block">{{ __('general.change_password') }}</button>
				    </div>
				</div>
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection