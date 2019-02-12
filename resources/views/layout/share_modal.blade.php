<div class="modal fade" id="share_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">{{ __('general.share') }}</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack" ng-click="show_party()">Topcorn</button>
				<a class="btn btn-outline-secondary border-0 btn-lg btn-block addfacebook" ng-href="{{config('constants.facebook.share_website')}}/@{{movie.title.length>0?'movie':'series'}}/{{$id}}" target="_blank">Facebook</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="share_modal_2" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">Select User(s)</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body scrollable-modal-body">
				<div class="btn-group-toggle">
					<label class="btn btn-block border-0 btn-tab mb-1" ng-class="page_variables.f_send_user[user.user_id]>0?'btn-tab':'btn-outline-secondary'" ng-repeat="user in page_variables.watch_togethers">
						<input type="checkbox" ng-attr-id="customCheck@{{$index}}" ng-model="page_variables.f_send_user[user.user_id]"> @{{user.user_name}}
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
				<button type="button" class="btn btn-outline-primary" ng-click="send_movie_to_users()">Send</button>
			</div>
		</div>
	</div>
</div>