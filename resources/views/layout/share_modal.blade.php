<div class="modal fade" id="share_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><span ng-if="!page_variables.is_with_review">{{ __('general.share') }}</span></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal" ng-if="page_variables.is_with_review" ng-click="delete_review(page_variables.this_review_id)">{{ __('general.delete') }}</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
				<button type="button" class="btn btn-outline-primary" data-dismiss="modal" ng-click="save_review()">{{ __('general.save') }}</button>
			</div>
		</div>
	</div>
</div>