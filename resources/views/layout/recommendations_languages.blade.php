<div class="">
	<p class="h6 text-muted pt-3">{{ __('general.language') }}</p>
	<div class="d-flex flex-wrap">
		<div class="col-6 col-sm-4 col-md-3 col-lg-2" ng-repeat="language in languages">
			<!--<label class="form-check-label nowrap">
				<input type="checkbox" class="form-check-input" ng-model="f_lang_model[language.i]" ng-change="get_first_page_data()">
				@{{language.o}}
			</label>-->
			<div class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" ng-attr-id="customCheck@{{$index}}" ng-model="f_lang_model[language.i]" ng-change="get_first_page_data()">
			  <label class="custom-control-label" for="customCheck@{{$index}}">@{{language.o}}</label>
			</div>
		</div>
	</div>
	<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">Choose</button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel"><span ng-if="!page_variables.is_with_review">{{ __('general.add_review') }}</span><span ng-if="page_variables.is_with_review">{{ __('general.edit_review') }}</span></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="btn-group-toggle" data-toggle="buttons">
					<label class="btn btn-secondary active" ng-repeat="language in languages">
						<input type="checkbox" checked autocomplete="off"> @{{language.o}}
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
				<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Apply</button>
			</div>
		</div>
	</div>
</div>