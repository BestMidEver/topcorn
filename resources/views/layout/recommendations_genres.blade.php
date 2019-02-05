<div>
	<button id="genres_button" class="btn btn-outline-secondary dropdown-toggle h6 mt-2 border-0" type="button" data-toggle="collapse" data-target="#collapseGenres"><span class="h6">{{ __('general.genre') }}</span></button>
	<div class="collapse" id="collapseGenres">
		<div>
			<!--<label class="form-check-label">col-6 col-sm-4 col-md-3 col-lg-2 ng-repeat="genre in genres" class="d-flex flex-wrap"
				<input type="checkbox" class="form-check-input" ng-model="f_genre_model['id_'+genre.i]" ng-change="get_first_page_data()">
				@{{genre.o}}
			</label>
			<div class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" ng-attr-id="customCheckGenre@{{$index}}" ng-model="f_genre_model['id_'+genre.i]" ng-change="get_first_page_data()">
			  <label class="custom-control-label" for="customCheckGenre@{{$index}}">@{{genre.o}}</label>
			</div>-->
			<div class="btn-group-toggle">
				<label class="btn btn-outline-secondary m-1 border-0" ng-class="{'active':f_lang_model[genre.i]}" ng-repeat="genre in genres">
					<input type="checkbox" ng-attr-id="customCheck@{{$index}}" ng-model="f_lang_model[genre.i]" ng-change="get_first_page_data()"> @{{genre.o}}
				</label>
			</div>
		</div>
	</div>
</div>