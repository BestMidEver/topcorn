@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_createlist')

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
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-heading"></i></div>
								</div>
								<input type="text" class="form-control" id="name" name="name" required autofocus>
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
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control" id="name" name="name" required></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label for="current_password">Sonuç Yazısı</label>
					</div>
					<div class="col-md-6">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control" id="name" name="name" required></textarea>
							</div>
						</div>
					</div>
				</div>
				<!-- Başlık & Giriş & Sonuç -->




				<!-- Liste Özellikleri -->
				<div class="row mt-5">
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
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-eye"></i></div>
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
					<div class="col-md-3 field-label-responsive">
						<label for="lang">Sıralama</label>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-sort"></i></div>
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
				<div class="row mt-5">
					<div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">Filmler</div>
					</div>
				</div>
				<div class="row mt-3" ng-repeat="l in list">
					<div class="card h-100 p-2 col-12">
						<div class="d-flex flex-row justify-content-end">
							<button href="#" class="btn btn-verydark border-circle text-white"><i class="fa fa-times"></i></button>
						</div>
						<div class="row no-gutters mt-3">
							<div class="input-group col-4 col-xl-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="fas fa-hashtag"></i></span>
								</div>
								<input type="number" class="form-control">
							</div>
							<div class="input-group col">
								<div class="input-group-prepend pl-3">
									<span class="input-group-text" id="basic-addon1"><i class="fas fa-film"></i></span>
								</div>
								<input id="vitrin_1" ng-show="!searchmode_1" type="text" class="form-control" ng-click="searchmode_1=true;set_focus(1)" ng-model="['title_chosen_'+$index]" placeholder="Filmin adını giriniz.">
								<input id="movie_id_1" ng-show="false" type="text" class="form-control" ng-model="id_chosen_1">
								<input id="back_of_vitrin_1" ng-show="searchmode_1" type="text" class="form-control" placeholder="Filmin adını giriniz." ng-focus="search_1=true" ng-blur="search_1=false" ng-model="input_1" ng-change="search_movie(1)" ng-model-options="{debounce: 750}">
								<div ng-show="(search_1 || choosing_1) && movies_1.length > 0 && searchmode_1" class="search-movie-results background-white py-3" ng-mouseenter="choosing_1=true" ng-mouseleave="choosing_1=false">
									<div class="result py-1" ng-repeat="movie in movies_1" ng-click="choose_movie(1, movie)">@{{movie.title}} <small ng-if="movie.release_date.length > 0"><em>(@{{movie.release_date.substring(0, 4)}})</em></small></div>
								</div>
							</div>
						</div>
						<div class="row no-gutters mt-3">
							<div class="col-4 col-xl-3">
								<img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{poster_path_1}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top" alt="Responsive image">
							</div>
							<div class="input-group col pl-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
							  </div>
							  <textarea class="form-control" aria-label="With textarea" placeholder="Boş bırakırsanız açıklamada filmin özeti yazar."></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex flex-row justify-content-center mt-4">
					<button href="#" class="btn btn-verydark border-circle text-white"><i class="fas fa-plus"></i> Film Ekle</button>
				</div>
				<!-- Filmler -->




				<!-- Submit -->
				<div class="row mt-5">
					<div class="col-md-3"></div>
					<div class="col-md-6">
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