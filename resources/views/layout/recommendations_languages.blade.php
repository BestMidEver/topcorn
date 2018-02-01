<div class="">
	<p class="h6 text-muted pt-3">{{ __('general.language') }}</p>
	<div class="d-flex flex-wrap">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2" ng-repeat="language in languages">
			<label class="form-check-label nowrap">
				<input type="checkbox" class="form-check-input" ng-model="f_lang_model[language.i]" ng-change="get_first_page_data()">
				@{{language.o}}
			</label>
		</div>
	</div>	
</div>