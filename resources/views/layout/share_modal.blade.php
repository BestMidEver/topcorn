<div class="modal fade" id="share_modal" tabindex="-1" role="dialog" aria-hidden="true" ng-cloak>
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">{{ __('general.share') }} - @{{movie.title.length>0?movie.title:movie.name}}</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addban" ng-click="show_party()">Topcorn</button>
				<a class="btn btn-outline-secondary border-0 btn-lg btn-block addfacebook" ng-href="{{config('constants.facebook.share_website')}}/@{{movie.title.length>0?'movie':'series'}}/{{$id_dash_title}}/{{App::getlocale()}}" target="_blank">Facebook</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="share_modal_2" tabindex="-1" role="dialog" aria-hidden="true" ng-cloak>
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">{{ __('general.select_users') }}</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body scrollable-modal-body">
				<div class="btn-group-toggle">
					<label class="btn btn-block border-0 mb-1" ng-class="page_variables.f_send_user[user.user_id]?'btn-tab':'btn-outline-secondary'" ng-repeat="user in page_variables.watch_togethers">
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