<div class="mt-3">
	<p class="h6 text-muted">{{ __('general.genre') }}</p>
	<div class="d-flex flex-wrap">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2" ng-repeat="genre in genres">
			<label class="form-check-label">
				<input type="checkbox" class="form-check-input" ng-model="f_genre_model['id_'+genre.i]" ng-change="get_first_page_data()">
				@{{genre.o}}
			</label>
		</div>
	</div>
</div>