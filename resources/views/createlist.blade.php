@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4">Liste Oluştur</h1>

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
						<div class="h6 text-muted">Başlık & Giriş & Sonuç</div>
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
				<div class="row mt-3">
				    <div class="col-md-3 field-label-responsive">
				        <label for="current_password">Giriş Yazısı</label>
				    </div>
				    <div class="col-md-6">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-user"></i></div>
				                </div>
				                <textarea type="text" class="form-control" id="name" name="name" required></textarea>
				            </div>
				        </div>
				    </div>
				</div>

				<!--<div class="row">
				    <div class="col-md-6">
				    	<button type="submit" class="btn btn-link btn-block" ng-disabled="is_save_disabled">Kaydet</button>
				    </div>
				    <div class="col-md-6">
				        <button type="submit" class="btn btn-primary btn-block" ng-disabled="is_save_disabled">Paylaş</button>
				    </div>
				</div>
			-->
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>


  <textarea class="form-control" aria-label="With textarea"></textarea>

@endsection