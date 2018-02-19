@extends('layout.appnew')

@section('passdata')
<script type="text/javascript">
pass={
    "angular_module_array":[], 
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/ForgetpasswordPageController.js"></script>
@endsection
@section('controllername', 'ForgetpasswordPageController')

@section('title')
{{ __('title.reset') }}
@endsection




@section('body')
<div class="container">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 py-3">
                <h5>{{ __('general.create_new_password') }}</h5>
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
                        <input type="text" name="email" class="form-control" id="email" value="{{ $email or old('email') }}" required autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            @if ($errors->has('email'))
                                <i class="fa fa-close"> {{ $errors->first('email') }}</i>
                            @endif
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="password">{{ __('general.new_password') }}</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
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
                        <span class="text-danger align-middle">
                            @if ($errors->has('password'))
                                <i class="fa fa-close"> {{ $errors->first('password') }}</i>
                            @endif
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="password-confirm">{{ __('general.new_password_confirmation') }}</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-prepend">    
                            <div class="input-group-text" style="width: 2.6rem"><i class="fa fa-repeat"></i></div>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control" id="password-confirm" required>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            @if ($errors->has('password_confirmation'))
                                <i class="fa fa-close"> {{ $errors->first('password_confirmation') }}</i>
                            @endif
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning text-white btn-block"><i class="fa fa-envelope loginbuttonfa" aria-hidden="true"></i> {{ __('general.create_new_password') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection