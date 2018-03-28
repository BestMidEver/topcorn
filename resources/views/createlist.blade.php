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
				<!-- Başlık & Giriş & Sonuç -->
				<div class="row">
				    <div class="col-12">
						<div class="h6 text-muted">Başlık & Giriş & Sonuç</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-12">
				        <label for="current_password">Başlık</label>
				    </div>
				    <div class="col-12">
				        <div class="">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				            	<div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-user"></i></div>
				                </div>
				                <input type="text" class="form-control" id="name" name="name" required autofocus>
				            </div>
				        </div>
				    </div>
				    <div class="col-12">
				        <div class="">
				            @if ($errors->has('name'))
				                <span class="text-danger align-middle float-right float-md-none">
				                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('name') }}
				                </span>
				            @endif
				        </div>
				    </div>
				</div>
				<div class="row mt-3">
				    <div class="col-12">
				        <label for="current_password">Giriş Yazısı</label>
				    </div>
				    <div class="col-12">
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
				<div class="row mt-3">
				    <div class="col-12">
				        <label for="current_password">Sonuç Yazısı</label>
				    </div>
				    <div class="col-12">
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
				<!-- Başlık & Giriş & Sonuç -->




				<!-- Liste Özellikleri -->
				<div class="row mt-5">
				    <div class="col-12">
						<div class="h6 text-muted">Liste Özellikleri</div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-12">
				        <label for="lang">Kimler Görebilir?</label>
				    </div>
				    <div class="col-12">
				        <div class="form-group">
				            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
				                <div class="input-group-prepend">
				                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-language"></i></div>
				                </div>
				                <select class="form-control" id="lang" name="lang" ng-model="lang">
									<option value="tr">Herkes</option>
									<option value="en">Sadece Ben</option>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-12">
				        <label for="lang">Filmlere Açıklama Ekle</label>
				    </div>
				    <div class="col-12">
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
				    <div class="col-12">
				        <label for="lang">Sıralama</label>
				    </div>
				    <div class="col-12">
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
				<!-- Liste Özellikleri -->




				<!-- Filmler -->
				<div class="row mt-3">
				    <div class="col-12">
						<div class="h6 text-muted">Filmler</div>
				    </div>
				</div>
				<div class="row mt-5">
					<div class="col"></div>
					<div class="col-12 col-lg-10 col-xl-8">
						<div class="card h-100">
							<div class="row">
							    <div class="col-12 field-label-responsive">
							        <label for="current_password">Sırası</label>
							    </div>
							    <div class="col-12">
							        <div class="">
							            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
							            	<div class="input-group-prepend">
							                	<div class="input-group-text" style="width: 2.6rem"><i class="fa fa-user"></i></div>
							                </div>
							                <input type="number" class="form-control" id="name" name="name" required>
							            </div>
							        </div>
							    </div>
							    <div class="col-12">
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
							    <div class="col-12">
							        <label for="current_password">Adı</label>
							    </div>
							    <div class="col-12">
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
							<div class="row no-gutters pt-2">
								<div class="col-4 col-xl-3">
									<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
								</div>

								<div class="col-8 lead lead-small">
									<div class="row mt-3">
									    <div class="col-12">
									        <label for="current_password">Açıklama</label>
									    </div>
									    <div class="col-12">
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
								</div>
							</div>
						</div>
					</div>
					<div class="col"></div>
				</div>
				<!-- Filmler -->




				<!-- Submit -->
				<div class="row mt-2">
				    <div class="col-md-3"></div>
				    <div class="col-12">
				        <button type="submit" class="btn btn-primary btn-block" ng-disabled="is_save_disabled">Kaydet</button>
				    </div>
				</div>
				<!-- Submit -->
			
			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection