@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_createlist')

@section('body')
<div class="row no-gutters" ng-cloak>
	<div class="col"></div>
	<div class="col-12 col-lg-10 col-xl-8">
		<div class="d-flex d-row">
			<h1 class="h5 text-center text-md-left col mt-3 mt-md-4 d-inline">{!! $liste != '[]' ? '<a href="/list/'.$liste[0]->id.'" class="text-dark" target='.$target.'>'.$liste[0]->title.'</a>' : __('general.create_list') !!}</h1>
			@if(Auth::check() && $liste != '[]')
				@if($liste[0]->user_id == Auth::id())
			<div class="btn-group mt-2">
				<button type="button" class="text-right btn btn-outline-secondary border-0 addfacebook border-no-radius mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-ellipsis-v"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					<button class="dropdown-item" ng-click="confirm_delete({{ $liste[0]->id }},'{{ __('general.list_remove_confirm') }}')">{{ __('general.remove') }}</button>
				</div>
			</div>
				@endif
			@endif
		</div>
	</div>
	<div class="col"></div>
</div>


	@if(session()->has('status'))
    <div class="alert alert-success"> 
    {!! session('status') !!}
    </div>
	@endif

<div class="container-fluid mt-3" ng-cloak>
	<div class="row">
		<div class="col"></div>
		<div class="col-12 col-lg-10 col-xl-8">
			<form id="the_form" class="form-horizontal" role="form" method="POST" action="/createlist">
				{{ csrf_field() }}
				<input type="number" class="d-none" name="list_id" value="{{  $id }}">
				<!-- Başlık & Giriş & Sonuç -->
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">{{ __('general.list_description') }}</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="current_password">{{ __('general.header') }}</label>
					</div>
					<div class="col-md-9">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-heading"></i></div>
								</div>
								<input type="text" class="form-control" id="header" name="header" value="{{ $liste != '[]' ? $liste[0]->title : '' }}" required autofocus>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label for="current_password">{{ __('general.intro') }}</label>
					</div>
					<div class="col-md-9">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control auto-resize" id="entry_1" name="entry_1">{{ $liste != '[]' ? $liste[0]->entry_1 : '' }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label for="current_password">{{ __('general.conclusion') }}</label>
					</div>
					<div class="col-md-9">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control auto-resize" id="entry_2" name="entry_2">{{ $liste != '[]' ? $liste[0]->entry_2 : '' }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<!-- Başlık & Giriş & Sonuç -->




				<!-- Liste Özellikleri -->
				<div class="row mt-5">
					<div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">{{ __('general.list_properties') }}</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="visibility">{{ __('general.visibility') }}</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-eye"></i></div>
								</div>
								<select class="form-control" id="visibility" name="visibility">
									<option value="1" {{ $liste != '[]' ? ($liste[0]->visibility == 1 ? 'selected' : '') : 'selected' }}>{{ __('general.everyone') }}</option>
									<option value="0" {{ $liste != '[]' ? ($liste[0]->visibility == 0 ? 'selected' : '') : '' }}>{{ __('general.only_me') }}</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="sort_by">{{ __('general.ordering') }}</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-sort"></i></div>
								</div>
								<select class="form-control" id="sort_by" name="sort_by">
									<option value="2" {{ $liste != '[]' ? ($liste[0]->sort == 2 ? 'selected' : '') : 'selected' }}>{{ __('general.ordering_321') }}</option>
									<option value="1" {{ $liste != '[]' ? ($liste[0]->sort == 1 ? 'selected' : '') : '' }}>{{ __('general.ordering_123') }}</option>
									<option value="0" {{ $liste != '[]' ? ($liste[0]->sort == 0 ? 'selected' : '') : '' }}>{{ __('general.disabled') }}</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<!-- Liste Özellikleri -->




				<!-- Filmler -->
				<div class="row mt-5">
					<div class="col-md-3 field-label-responsive">
						<div class="h6 text-muted">{{ __('general.p_items') }}</div>
					</div>
				</div>
				<div class="row mt-3 mb-5" ng-repeat="movie in movies">
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
								<input type="number" name="items[@{{$index}}][0]" ng-model="movie.position" class="form-control">
							</div>
							<!-- Order number -->


							
							<div class="input-group col mt-3 mt-md-0">
								<div class="input-group-prepend pl-md-3">
									<button class="btn btn-outline-secondary" ng-class="{'active':movie.mode!=1}" ng-click="movie.mode=0;search_movie(movie);set_focus($index)" type="button">Movie</button>
									<button class="btn btn-outline-secondary" ng-class="{'active':movie.mode==1}" ng-click="movie.mode=1;search_movie(movie);set_focus($index)" type="button">Series</button>
									<input type="number" class="d-none" name="items[@{{$index}}][3]" ng-value="movie.mode">
								</div>
								<input ng-attr-id="vitrin_@{{$index}}" ng-show="!movie.searchmode" type="text" class="form-control" ng-click="movie.searchmode=true;set_focus($index)" ng-init="movie.movie_title=movie.movie_title+(movie.release_date.length > 0 ? ' ('+movie.release_date.substring(0, 4)+')' : '')" ng-model="movie.movie_title" 
								{!!'placeholder="@{{movie.mode!=1?\''.__('general.enter_movie_name').'\':\''.__('general.enter_series_name').'\'}}"'!!}>
								<input ng-attr-id="movie_id_@{{$index}}" ng-show="false" type="text" class="form-control" ng-model="movie.movie_id" name="items[@{{$index}}][1]">
								<input ng-attr-id="back_of_vitrin_@{{$index}}" ng-show="movie.searchmode" type="text" class="form-control" {!!'placeholder="@{{movie.mode!=1?\''.__('general.enter_movie_name').'\':\''.__('general.enter_series_name').'\'}}"'!!} ng-focus="movie.search=true" ng-blur="movie.search=false" ng-model="movie.input" ng-change="search_movie(movie)" ng-model-options="{debounce: 750}">
								<div ng-show="(movie.search || movie.choosing) && movie.movies.length > 0 && movie.searchmode" class="search-movie-results background-white py-3" ng-mouseenter="movie.choosing=true" ng-mouseleave="movie.choosing=false">
									<div class="result py-1" ng-repeat="f in movie.movies" ng-click="choose_movie($parent.$index, f, movie.mode)">@{{movie.mode!=1?f.title:f.name}} <small ng-if="f.release_date.length > 0"><em>(@{{f.release_date.substring(0, 4)}})</em></small><small ng-if="f.first_air_date.length > 0"><em>(@{{f.first_air_date.substring(0, 4)}})</em></small></div>
								</div>
							</div>
						</div>


						<div class="row no-gutters mt-3" ng-if="movie.movie_title.length>0">
							<div class="col-3 col-md-4 col-xl-3">
								<img ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" class="card-img-top" alt="Responsive image">
							</div>
							<div class="input-group col pl-3">
								<div class="input-group-prepend d-none d-md-flex">
									<span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
								</div>
								<textarea class="form-control" aria-label="With textarea" placeholder="@{{movie.overview}}" name="items[@{{$index}}][2]">@{{movie.explanation}}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex flex-row justify-content-center">
					<button type="button" ng-click="new_list();movies[movies.length-1].searchmode=true;set_focus(movies.length-1)" class="btn btn-verydark border-circle text-white"><i class="fas fa-plus"></i> {{ __('general.add_movie') }}</button>
				</div>
				<!-- Filmler -->




				<!-- Submit -->
				<div class="row mt-5">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary btn-block">{{ __('general.save') }}</button>
					</div>
				</div>
				<!-- Submit -->

			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection