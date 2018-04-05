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
				<input type="number" class="d-none" name="list_id" value="1">
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
								<input type="text" class="form-control" id="header" name="header" required autofocus>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-control-feedback">
							@if ($errors->has('header'))
							<span class="text-danger align-middle float-right float-md-none">
								<i class="fas fa-exclamation-circle"></i> {{ $errors->first('header') }}
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
								<textarea type="text" class="form-control" id="entry_1" name="entry_1"></textarea>
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
								<textarea type="text" class="form-control" id="entry_2" name="entry_2"></textarea>
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
						<label for="visibility">Kimler Görebilir?</label>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-eye"></i></div>
								</div>
								<select class="form-control" id="visibility" name="visibility" ng-model="visibility">
									<option value="1">Herkes</option>
									<option value="0">Sadece Ben</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="sort_by">Sıralama</label>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-sort"></i></div>
								</div>
								<select class="form-control" id="sort_by" name="sort_by" ng-model="sort_by">
									<option value="2">Büyükten Küçüğe</option>
									<option value="1">Küçükten Büyüğe</option>
									<option value="0">Devre Dışı</option>
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
				<div class="row mt-3 mb-5" ng-repeat="l in list">
					<div class="card h-100 p-2 col-12">
						<!-- Remove from list -->
						<div class="d-flex flex-row justify-content-end">
							<button type="button" ng-click="remove_from_list($index)" class="btn btn-verydark border-circle text-white"><i class="fa fa-times"></i></button>
						</div>
						<!-- Remove from list -->


						<div class="row no-gutters mt-3">
							<!-- Order number -->
							<div class="input-group col-12 col-md-4 col-xl-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-hashtag"></i></span>
								</div>
								<input type="number" name="item_position_@{{$index}}" ng-model="l.position" class="form-control">
							</div>
							<!-- Order number -->

							
							<div class="input-group col mt-3 mt-md-0">
								<div class="input-group-prepend pl-md-3">
									<span class="input-group-text"><i class="fas fa-film"></i></span>
								</div>
								<input ng-attr-id="vitrin_@{{$index}}" ng-show="!l.searchmode" type="text" class="form-control" ng-click="l.searchmode=true;set_focus($index)" ng-model="l.movie_title" placeholder="Filmin adını giriniz.">
								<input ng-attr-id="movie_id_@{{$index}}" ng-show="false" type="text" class="form-control" ng-model="l.movie_id" name="item_movie_id_@{{$index}}">
								<input ng-attr-id="back_of_vitrin_@{{$index}}" ng-show="l.searchmode" type="text" class="form-control" placeholder="Filmin adını giriniz." ng-focus="l.search=true" ng-blur="l.search=false" ng-model="l.input" ng-change="search_movie($index)" ng-model-options="{debounce: 750}">
								<div ng-show="(l.search || l.choosing) && l.movies.length > 0 && l.searchmode" class="search-movie-results background-white py-3" ng-mouseenter="l.choosing=true" ng-mouseleave="l.choosing=false">
									<div class="result py-1" ng-repeat="movie in l.movies" ng-click="choose_movie($parent.$index, movie)">@{{movie.title}} <small ng-if="movie.release_date.length > 0"><em>(@{{movie.release_date.substring(0, 4)}})</em></small></div>
								</div>
							</div>
						</div>


						<div class="row no-gutters mt-3" ng-if="l.movie_title.length>0">
							<div class="col-3 col-md-4 col-xl-3">
								<img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{l.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top" alt="Responsive image">
							</div>
							<div class="input-group col pl-3">
								<div class="input-group-prepend d-none d-md-flex">
									<span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
								</div>
								<textarea class="form-control" aria-label="With textarea" placeholder="@{{l.overview}}" name="item_explanation_@{{$index}}"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex flex-row justify-content-center">
					<button type="button" ng-click="new_list()" class="btn btn-verydark border-circle text-white"><i class="fas fa-plus"></i> Film Ekle</button>
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