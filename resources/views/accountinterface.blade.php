@extends('layout.app')

@include('head.head_accountinterface')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.account') }}</h5>

<div class="container-fluid mt-3 pb-1">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account">{{ __('general.profile') }}</a>
		</li>
		<li class="nav-item">
			<a class="nav-link text-muted" href="/account/password">{{ __('general.password') }}</a>
		</li>
		<li class="nav-item mb-2">
			<a class="nav-link active text-muted" href="/account/interface">{{ __('general.interface') }}</a>
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
			<form id="the_form" class="form-horizontal" role="form" method="POST" action="/account/interface">
				{{ csrf_field() }}
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">Dil</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="lang">{{ __('general.primary_language') }}</label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-language"></i></div>
				                </div>
				                <select class="form-control" id="lang" name="lang" ng-model="lang" ng-change="check_save_disabled()" autofocus>
									<option value="tr" {{ Auth::User()->lang == 'tr' ? 'selected' : '' }}>Türkçe</option>
									<option value="en" {{ Auth::User()->lang == 'en' ? 'selected' : '' }}>English</option>
									<option value="hu" {{ Auth::User()->lang == 'hu' ? 'selected' : '' }}>Magyar</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="secondary_lang" ng-mouseenter="hovering_seco=true" ng-mouseleave="hovering_seco=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_secondary_language') }}">{{ __('general.secondary_language') }} <span ng-show="!hovering_seco"><i class="far fa-question-circle"></i></span><span ng-show="hovering_seco"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-language"></i></div>
				                </div>
				                <select class="form-control" id="secondary_lang" name="secondary_lang" ng-model="secondary_lang" ng-change="check_save_disabled()">
									<option value="tr" {{ Auth::User()->secondary_lang == 'tr' ? 'selected' : '' }}>Türkçe</option>
									<option value="en" {{ Auth::User()->secondary_lang == 'en' ? 'selected' : '' }}>English</option>
									<option value="hu" {{ Auth::User()->secondary_lang == 'hu' ? 'selected' : '' }}>Magyar</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="hover_title_language" ng-mouseenter="hovering_hove=true" ng-mouseleave="hovering_hove=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_hover_title') }}">{{ __('general.hover_title_language') }} <span ng-show="!hovering_hove"><i class="far fa-question-circle"></i></span><span ng-show="hovering_hove"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-mouse-pointer"></i></div>
				                </div>
				                <select class="form-control" id="hover_title_language" name="hover_title_language" ng-model="hover_title_language" ng-change="check_save_disabled()">
									<option value=1 {{ Auth::User()->hover_title_language == 1 ? 'selected' : '' }}>{{ __('general.movies_original_language') }}</option>
									<option value=0 {{ Auth::User()->hover_title_language == 0 ? 'selected' : '' }}>{{ __('general.my_secondary_language') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>

				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">Görüntü</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="theme" ng-mouseenter="hovering_them=true" ng-mouseleave="hovering_them=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_theme') }}">Tema <span ng-show="!hovering_them"><i class="far fa-question-circle"></i></span><span ng-show="hovering_them"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-paint-brush"></i></div>
				                </div>
				                <select class="form-control" id="theme" name="theme" ng-model="theme" ng-change="check_save_disabled()">
									<option value=2 {{ Auth::User()->theme == 2 ? 'selected' : '' }}>{{ Auth::User()->theme}}Zifiri Karanlık</option>
									<option value=1 {{ Auth::User()->theme == 1 ? 'selected' : '' }}>Karanlık</option>
									<option value=0 {{ Auth::User()->theme == 0 ? 'selected' : '' }}>Aydınlık</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="image_quality" ng-mouseenter="hovering_imag=true" ng-mouseleave="hovering_imag=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_image_quality') }}">{{ __('general.image_quality') }} <span ng-show="!hovering_imag"><i class="far fa-question-circle"></i></span><span ng-show="hovering_imag"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="far fa-image"></i></div>
				                </div>
				                <select class="form-control" id="image_quality" name="image_quality" ng-model="image_quality" ng-change="check_save_disabled()">
									<option value=2 {{ Auth::User()->image_quality == 2 ? 'selected' : '' }}>{{ __('general.high') }}</option>
									<option value=1 {{ Auth::User()->image_quality == 1 ? 'selected' : '' }}>{{ __('general.medium') }}</option>
									<option value=0 {{ Auth::User()->image_quality == 0 ? 'selected' : '' }}>{{ __('general.low') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="margin_x_setting" ng-mouseenter="hovering_marg=true" ng-mouseleave="hovering_marg=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_full_screen') }}">{{ __('general.margin_x_setting') }} <span ng-show="!hovering_marg"><i class="far fa-question-circle"></i></span><span ng-show="hovering_marg"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-expand-arrows-alt"></i></div>
				                </div>
				                <select class="form-control" id="margin_x_setting" name="margin_x_setting" ng-model="margin_x_setting" ng-change="check_save_disabled()">
									<option value=2 {{ Auth::User()->margin_x_setting == 2 ? 'selected' : '' }}>{{ __('general.active') }}</option>
									<option value=1 {{ Auth::User()->margin_x_setting == 1 ? 'selected' : '' }}>{{ __('general.standard') }}</option>
									<option value=0 {{ Auth::User()->margin_x_setting == 0 ? 'selected' : '' }}>{{ __('general.disabled') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="open_new_tab" ng-mouseenter="hovering_open=true" ng-mouseleave="hovering_open=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_open_new_tab') }}">{{ __('general.open_new_tab') }} <span ng-show="!hovering_open"><i class="far fa-question-circle"></i></span><span ng-show="hovering_open"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-external-link-alt"></i></div>
				                </div>
				                <select class="form-control" id="open_new_tab" name="open_new_tab" ng-model="open_new_tab" ng-change="check_save_disabled()">
									<option value=1 {{ Auth::User()->open_new_tab == 1 ? 'selected' : '' }}>{{ __('general.active') }}</option>
									<option value=0 {{ Auth::User()->open_new_tab == 0 ? 'selected' : '' }}>{{ __('general.disabled') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>

				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">Görüntü</div>
				    </div>
				</div>

				<div class="row">
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