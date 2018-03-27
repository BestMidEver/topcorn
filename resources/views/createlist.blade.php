@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<div class="container-fluid mt-3">
	<div class="row">
		<div class="col"></div>
		<div class="col-12 col-xl-10">
			<form id="the_form" class="form-horizontal" role="form" method="POST" action="/createlist">
				{{ csrf_field() }}
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">Liste Özellikleri</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="lang">Kimler Görebilir?</label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-language"></i></div>
				                </div>
				                <select class="form-control" id="lang" name="lang" ng-model="lang" autofocus>
									<option value="tr">Herkes</option>
									<option value="en">Sadece Ben</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="lang">Filmlere Açıklama Ekle</label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-language"></i></div>
				                </div>
				                <select class="form-control" id="lang" name="lang" ng-model="lang">
									<option value="tr">Etkin</option>
									<option value="en">Devre Dışı</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="lang">Sıralama</label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-language"></i></div>
				                </div>
				                <select class="form-control" id="lang" name="lang" ng-model="lang">
									<option value="tr">Büyükten Küçüğe</option>
									<option value="en">Küçükten Büyüğe</option>
									<option value="fd">Devre Dışı</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>

				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">Etiket</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">Başlık</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-user"></i></div>
				                </div>
				                <input type="text" class="form-control" id="name" name="name" required>
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
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">Giriş Yazısı</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-user"></i></div>
				                </div>
				                <input type="text" class="form-control" id="name" name="name" required>
				            </div>
				        </div>
				    </div>
				</div>

				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">{{ __('general.options') }}</div>
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
									<option value=1>{{ __('general.active') }}</option>
									<option value=0>{{ __('general.disabled') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="pagination" ng-mouseenter="hovering_pagi=true" ng-mouseleave="hovering_pagi=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_pagination') }}">{{ __('general.pagination') }} <span ng-show="!hovering_pagi"><i class="far fa-question-circle"></i></span><span ng-show="hovering_pagi"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-align-justify"></i></div>
				                </div>
				                <select class="form-control" id="pagination" name="pagination" ng-model="pagination" ng-change="check_save_disabled()">
									<option value=48>48</option>
									<option value=24>24</option>
									<option value=12>12</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="show_crew" ng-mouseenter="hovering_crew=true" ng-mouseleave="hovering_crew=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_show_crew') }}">{{ __('general.show_crew') }} <span ng-show="!hovering_crew"><i class="far fa-question-circle"></i></span><span ng-show="hovering_crew"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-users"></i></div>
				                </div>
				                <select class="form-control" id="show_crew" name="show_crew" ng-model="show_crew" ng-change="check_save_disabled()">
									<option value=1>{{ __('general.active') }}</option>
									<option value=0>{{ __('general.disabled') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3 field-label-responsive">
				        <label for="advanced_filter" ng-mouseenter="hovering_adva=true" ng-mouseleave="hovering_adva=false" data-toggle="tooltip" data-placement="top" title="{{ __('long_texts.hint_advanced_filter') }}">{{ __('general.advanced_recommendations') }} <span ng-show="!hovering_adva"><i class="far fa-question-circle"></i></span><span ng-show="hovering_adva"><i class="fas fa-question-circle"></i></span></label>
				    </div>
				    <div class="col-md-6">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-filter"></i></div>
				                </div>
				                <select class="form-control" id="advanced_filter" name="advanced_filter" ng-model="advanced_filter" ng-change="check_save_disabled()">
									<option value=1>{{ __('general.active') }}</option>
									<option value=0>{{ __('general.disabled') }}</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>

				<div class="row">
				    <div class="col-md-6">
				    	<button type="submit" class="btn btn-link btn-block" ng-disabled="is_save_disabled">Kaydet</button>
				    </div>
				    <div class="col-md-6">
				        <button type="submit" class="btn btn-primary btn-block" ng-disabled="is_save_disabled">Paylaş</button>
				    </div>
				</div>
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection