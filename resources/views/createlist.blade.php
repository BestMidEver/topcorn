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
							<button ng-click="remove_from_list($index)" class="btn btn-verydark border-circle text-white"><i class="fa fa-times"></i></button>
						</div>
						<div class="row no-gutters mt-3">
							<div class="input-group col-4 col-xl-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-hashtag"></i></span>
								</div>
								<input type="number" ng-model="model['position_'+$index]" ng-value="l.position" class="form-control">
							</div>
							<div class="input-group col">
								<div class="input-group-prepend pl-3">
									<span class="input-group-text"><i class="fas fa-film"></i></span>
								</div>
								<input ng-attr-id="vitrin_@{{$index}}" ng-show="!model['searchmode_'+$index]" type="text" class="form-control" ng-click="model['searchmode_'+$index]=true;set_focus($index)" ng-model="model['title_chosen_'+$index]" ng-value="l.movie_title" placeholder="Filmin adını giriniz.">
								<input ng-attr-id="movie_id_@{{$index}}" ng-show="false" type="text" class="form-control" ng-model="model['id_chosen_'+$index]" ng-value="l.movie_id">
								<input ng-attr-id="back_of_vitrin_@{{$index}}" ng-show="model['searchmode_'+$index]" type="text" class="form-control" placeholder="Filmin adını giriniz." ng-focus="model['search_'+$index]=true" ng-blur="model['search_'+$index]=false" ng-model="model['input_'+$index]" ng-change="search_movie($index)" ng-model-options="{debounce: 750}">
								<div ng-show="(model['search_'+$index] || model['choosing_'+$index]) && model['movies_'+$index].length > 0 && model['searchmode_'+$index]" class="search-movie-results background-white py-3" ng-mouseenter="model['choosing_'+$index]=true" ng-mouseleave="model['choosing_'+$index]=false">
									<div class="result py-1" ng-repeat="movie in model['movies_'+$index]" ng-click="choose_movie($index, movie)">@{{movie.title}} <small ng-if="movie.release_date.length > 0"><em>(@{{movie.release_date.substring(0, 4)}})</em></small></div>
								</div>
							</div>
						</div>
						<div class="row no-gutters mt-3">
							<div class="col-4 col-xl-3">
								<img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{model['poster_path_'+$index]}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top" alt="Responsive image">
							</div>
							<div class="input-group col pl-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
								</div>
								<textarea class="form-control" aria-label="With textarea" placeholder="@{{model['plot_'+$index]}}"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex flex-row justify-content-center mt-4">
					<button ng-click="new_list()" class="btn btn-verydark border-circle text-white"><i class="fas fa-plus"></i> Film Ekle</button>
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