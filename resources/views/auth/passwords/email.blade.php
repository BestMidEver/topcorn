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
{{ __('title.email') }}
@endsection




@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 py-3">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        </div>
    </div>
    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 py-3">
                <h5>{{ __('general.forgot_my_password') }}</h5>
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
                        <span class="text-danger align-middle">
                            @if ($errors->has('email'))
                                <i class="fa fa-close"> {{ $errors->first('email') }}</i>
                            @endif
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning text-white btn-block"><i class="fa fa-envelope loginbuttonfa" aria-hidden="true"></i> {{ __('general.send_instructions') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection