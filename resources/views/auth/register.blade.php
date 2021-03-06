@extends('layout.appnew')

@section('passdata')
<script type="text/javascript">
pass={
    "angular_module_array":[], 
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/RegisterPageController.js"></script>
@endsection
@section('controllername', 'RegisterPageController')

@section('title')
{{ __('title.register') }}
@endsection

@section('body')
<div class="container">
    <form class="form-horizontal" role="form" method="POST" action="/register">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 py-3">
                <h5>{{ __('navbar.register') }}</h5>
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
                <a href="{{url('log_in/facebook')}}/@{{fb_remember}}" class="btn btn-facebook text-white btn-block"><i class="fab fa-facebook-square loginbuttonfa"></i> {{ __('general.login_via_facebook') }}</a>
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
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="name">{{ __('general.user_name') }}</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                        </div>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle float-right float-md-none">
                        @if ($errors->has('name'))
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first('name') }}
                        @endif
                    </span>
                </div>
            </div>
        </div>
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
                        <span class="text-danger align-middle float-right float-md-none">
                            @if ($errors->has('email'))
                                <i class="fas fa-exclamation-circle"></i> {{ $errors->first('email') }}
                            @endif
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="email">{{ __('general.email_confirmation') }}</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="width: 2.6rem"><i class="fas fa-redo"></i></div>
                        </div>
                        <input type="text" name="email_confirmation" class="form-control" id="email-confirmation" value="{{ old('email_confirmation') }}" required autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            <!-- Put e-mail validation error messages here -->
                        </span>
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
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle float-right float-md-none">
                        @if ($errors->has('password'))
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first('password') }}
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="password">{{ __('general.password_confirmation') }}</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="width: 2.6rem">
                                <i class="fas fa-redo"></i>
                            </div>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control"
                               id="password-confirm" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning text-white btn-block"><i class="fa fa-envelope loginbuttonfa" aria-hidden="true"></i> {{ __('general.save') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection