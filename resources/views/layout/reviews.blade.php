<div class="container-fluid px-0 mt-5" ng-cloak>	
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<span class="mb-0 pr-2 align-middle mt-3">{{ __('general.reviews') }}</span>
		@if(Auth::check())
		<button data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-secondary addban border-0" ng-click="setFocus('input_review')"
				@if(Auth::User()->tt_movie < 50)
            data-toggle="popover" data-placement="bottom" title='{{ __("tutorial.hint") }}<a class="close tooltip-x" href="#close-tooltip">&times;</a>' id="review"
            	@endif
			><div><i class="fas fa-pencil-alt"></i></div> <span ng-if="!page_variables.is_with_review">{{ __('general.add_review') }}</span><span ng-if="page_variables.is_with_review">{{ __('general.edit_review') }}</span></button>
        @endif
	</div>
	<div class="container-fluid">
		<div ng-if="page_variables.reviews.length>0" class="py-4" ng-repeat="review in page_variables.reviews" ng-hide="review.content==''">
			<div class="d-flex justify-content-between">
				<div class="h6 pb-2" ng-if="review.author.length>0">@{{review.author}}</div>
				<div class="d-inline" ng-if="review.name.length>0"><a class="h6 pb-2 text-dark d-inline" ng-href="/profile/@{{review.user_id}}">@{{review.name}}</a> <span class="ml-2" ng-if="review.rate>0"><i class="fas fa-star" ng-class="{1:'text-danger', 2:'text-warning', 3:'text-secondary', 4:'text-info', 5:'text-success'}[review.rate]" ng-repeat="n in [] | range:review.rate"></i><i class="far fa-star text-muted" ng-repeat="n in [] | range:(5-review.rate)"></i></span></div>
				<div class="h6">
					<button class="btn btn-outline-secondary btn-sm border-0 mt-0 addseen opacity-1" ng-disabled="review.is_mine==1||review.is_mine==undefined" ng-click="like_review($index)">
						<div ng-class="{'text-success':review.count>0}"><i class="fa-heart" ng-class="{0:'far', 1:'fas', undefined:'far'}[review.is_liked]"></i><span ng-if="review.count>0"> @{{review.count}}</span></div>
					</button>
				</div>
			</div>
			<div id="@{{'accordion'+$index}}">
				<div ng-if="review.id == 'long'">
					<div id="@{{'collapse'+$index+'a'}}" data-parent="@{{'#accordion'+$index}}" class="lead lead-small collapse">
						<div>
							<div ng-bind-html="review.content"></div>
						</div>
						<div class="text-center pt-0">
							<button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white hidereview" data-toggle="collapse" data-target="@{{'#collapse'+$index+'b'}}" aria-expanded="true"><i class="fa fa-angle-up"></i></button>
						</div>
					</div>
				</div>
				<div>
					<div id="@{{'collapse'+$index+'b'}}" data-parent="@{{'#accordion'+$index}}" class="lead lead-small collapse show">
						<div>
							<div ng-bind-html="review.url"></div>
						</div>
						<div ng-if="review.id == 'long'">
							<div class="text-center pt-1">
								<button class="btn btn-outline-secondary border-0 text-muted hover-white showreview" data-toggle="collapse" data-target="@{{'#collapse'+$index+'a'}}" aria-expanded="false"><small>{{ __('general.read_all') }}</small></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="p-5" ng-if="!page_variables.reviews.length>0">
		<div class="text-muted text-center">{{ __('general.no_result_review') }}</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-cloak>
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel"><span ng-if="!page_variables.is_with_review">{{ __('general.add_review') }}</span><span ng-if="page_variables.is_with_review">{{ __('general.edit_review') }}</span></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="message-text" class="col-form-label text-muted">
							<span ng-if="page_variables.active_tab_2==-1||page_variables.active_tab_2==undefined">@{{movie.title}}@{{series.name}}</span> 
							<span ng-if="page_variables.active_tab_2>0">S@{{series.episodes[page_variables.active_tab_2-1].season_number>9?series.episodes[page_variables.active_tab_2-1].season_number:'0'+series.episodes[page_variables.active_tab_2-1].season_number}}E@{{series.episodes[page_variables.active_tab_2-1].episode_number>9?series.episodes[page_variables.active_tab_2-1].episode_number:'0'+series.episodes[page_variables.active_tab_2-1].episode_number}}</span>
						</label>
						<textarea rows="5" class="form-control" id="input_review" ng-model="page_variables.review_textarea"></textarea>
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