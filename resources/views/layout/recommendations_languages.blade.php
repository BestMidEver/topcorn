<div class="pt-2">
	<button id="languages_button" class="btn btn-outline-secondary dropdown-toggle h6 m-0 border-0" type="button" data-toggle="collapse" data-target="#collapseLanguages"><span class="h6">{{ __('general.language') }}</span></button>
	<div class="collapse" id="collapseLanguages">
		<div class="">
			<!--<label class="form-check-label nowrap">col-6 col-sm-4 col-md-3 col-lg-2 
				<input type="checkbox" class="form-check-input" ng-model="f_lang_model[language.i]" ng-change="get_first_page_data()">
				@{{language.o}}
			</label>
			<div class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input" ng-attr-id="customCheck@{{$index}}" ng-model="f_lang_model[language.i]" ng-change="get_first_page_data()">
			  <label class="custom-control-label" for="customCheck@{{$index}}">@{{language.o}}</label>
			</div>-->
			<div class="btn-group-toggle">
				<label class="btn m-1 border-0" ng-class="f_lang_model[language.i]?'btn-tab':'btn-outline-secondary'" ng-repeat="language in languages">
					<input type="checkbox" ng-attr-id="customCheck@{{$index}}" ng-model="f_lang_model[language.i]" ng-change="get_first_page_data()"> @{{language.o}}
				</label>
			</div>
		</div>
	</div>
</div>

<!--	<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">Choose</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel"><span>Choose Original Languages</span></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="btn-group-toggle row" data-toggle="buttons">
					<label class="btn col btn-outline-secondary m-1 border-0" ng-repeat="language in languages">
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
</div>-->