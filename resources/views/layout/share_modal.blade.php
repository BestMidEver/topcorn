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
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack" data-toggle="modal" data-target="#share_modal_2">Topcorn</button>
				<a class="btn btn-outline-secondary border-0 btn-lg btn-block addfacebook" ng-href="{{config('constants.facebook.share_website')}}/@{{movie.title.length>0?'movie':'series'}}/{{$id}}" target="_blank">Facebook</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="share_modal_2" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">{{ __('general.share') }}</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">ZSoofiiia</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">mekk mesterr</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">aykut</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Hüseyin</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Cuniiii iD:D:</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">muhaha</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">ZSoofiiia</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">mekk mesterr</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">aykut</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Hüseyin</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Cuniiii iD:D:</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">muhaha</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">ZSoofiiia</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">ZSoofiiia</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">mekk mesterr</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">aykut</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Hüseyin</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Cuniiii iD:D:</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">muhaha</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">ZSoofiiia</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">mekk mesterr</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">aykut</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Hüseyin</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">Cuniiii iD:D:</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">muhaha</button>
				<button type="button" class="btn btn-outline-secondary border-0 btn-lg btn-block addblack">ZSoofiiia</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
				<button type="button" class="btn btn-outline-primary" data-dismiss="modal" ng-click="">Send</button>
			</div>
		</div>
	</div>
</div>