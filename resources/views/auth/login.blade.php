@extends('layout.appnew')

@section('passdata')
<script type="text/javascript">
pass={
    "angular_module_array":[], 
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/LoginPageController.js"></script>
@endsection
@section('controllername', 'LoginPageController')

@section('title')
{{ __('title.login') }}
@endsection




@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 py-3">
            <h5>{{ __('navbar.login') }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" ng-model="fb_remember" ng-init="fb_remember=false"> {{ __('general.remember_me') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <a href="#@{{fb_remember}}" class="btn btn-facebook text-white btn-block"><i class="fab fa-facebook-square loginbuttonfa"></i> {{ __('general.login_via_facebook') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col my-5">
        </div>
        <div class="col-3 col-md-2 col-lg-1">
            <div class="h-100 d-flex flex-column justify-content-center text-center text-muted">
                {{ __('general.or') }}
            </div>
        </div>
        <div class="col my-5">
        </div>
    </div>
    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="email">{{ __('general.email') }}</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                        </div>
                        <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    @if ($errors->has('email'))
                        <span class="text-danger align-middle">
                            <i class="fa fa-close"> {{ $errors->first('email') }}</i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="password">{{ __('general.password') }}</label>
            </div>
            <div class="col-md-6">
                <div class="form-group has-danger">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                        </div>
                        <input type="password" name="password" class="form-control" id="password"
                               placeholder="" required>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    @if ($errors->has('password'))
                        <span class="text-danger align-middle">
                            <i class="fa fa-close"> {{ $errors->first('password') }}</i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('general.remember_me') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning text-white btn-block"><i class="fa fa-envelope loginbuttonfa"></i> {{ __('navbar.login') }}</button>
            </div>
        </div>
        <a href="{{ route('password.request') }}" class="text-muted"><div class="text-center mt-4">{{ __('general.forgot_my_password') }}</div></a>
    </form>
</div>
@endsection