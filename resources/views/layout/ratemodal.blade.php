<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="votecard modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="card">
				<img class="card-img" ng-src="{{config('constants.image.rate_modal')[$image_quality]}}@{{modalmovie.poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">
				<div class="card-img-overlay p-2">
					<div class="text-center h-100 d-flex flex-column justify-content-between">
						<div class="d-flex flex-row justify-content-between">
							<div class="faderdiv">
								<!--<button type="button" class="btn btn-secondary btn-sm badge-light float-left" data-toggle="tooltip" data-placement="bottom" title="{{ __('long_texts.the_question') }}">
									<i class="fa fa-question" aria-hidden="true"></i>
								</button>-->
							</div>
							<div class="faderdiv">
								<h4 data-toggle="tooltip" data-placement="bottom" data-original-title="@{{modalmovie.original_title}}"><a href="/movie/@{{modalmovie.id}}" target={{$target}}><span class="badge badge-light yeswrap p-1">@{{modalmovie.title}} <small><em>(@{{modalmovie.release_date.substring(0, 4)}})</em></small></span></a></h4>
							</div>
							<div class="faderdiv">
								<button type="button" class="btn btn-secondary btn-sm badge-light float-right" data-dismiss="modal" data-backdrop="false" aria-label="Close">
									<span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
								</button>
							</div>
						</div>
						<div class="d-flex flex-column votediv">
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-success btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==5}" ng-click="modalmovie.is_quick_rate ? quick_rate(5) : rate(modalmovie.index, 5)">{{ __('general.definitely_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-info btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==4}" ng-click="modalmovie.is_quick_rate ? quick_rate(4) : rate(modalmovie.index, 4)">{{ __('general.recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-secondary btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==3}" ng-click="modalmovie.is_quick_rate ? quick_rate(3) : rate(modalmovie.index, 3)">{{ __('general.not_sure') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-warning btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==2}" ng-click="modalmovie.is_quick_rate ? quick_rate(2) : rate(modalmovie.index, 2)">{{ __('general.dont_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2" ng-if="!(modalmovie.is_quick_rate && previous_quick_rate_movie)">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-danger btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==1}" ng-click="modalmovie.is_quick_rate ? quick_rate(1) : rate(modalmovie.index, 1)">{{ __('general.definitely_dont_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="row mt-2 align-items-end" ng-if="modalmovie.is_quick_rate && previous_quick_rate_movie">
								<div class="col-2 faderdiv">
									<button type="button" class="btn btn-secondary btn-sm badge-light float-left" ng-click="previous_quick_rate()">
										<i class="fa fa-undo" aria-hidden="true"></i>
									</button>
								</div>
								<div class="col-8 faderdiv">
									<button class="btn btn-danger btn-lg" ng-class="{'bordered_button':modalmovie.rate_code==1}" ng-click="modalmovie.is_quick_rate ? quick_rate(1) : rate(modalmovie.index, 1)">{{ __('general.definitely_dont_recommend') }}</button>
								</div>
								<div class="col-2"></div>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-between align-items-end">
							<div class="faderdiv">
								<button type="button" class="btn btn-secondary btn-sm badge-light float-left touch-light" ng-class="modalmovie.later_id!=null ? 'text-warning' : 'text-muted'" ng-show="modalmovie.is_quick_rate" ng-click="modalmovie.is_quick_rate ? quick_later() : later(modalmovie.index)">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
								</button>
							</div>
							<div class="faderdiv">
								<button class="btn btn-secondary badge-light p-1 touch-light" ng-click="modalmovie.is_quick_rate ? quick_rate(0) : rate(modalmovie.index, null)">{{ __('general.havent_seen') }}</button>
							</div>
							<div class="faderdiv">
								<button type="button" class="btn btn-secondary btn-sm badge-light float-left touch-light" ng-class="modalmovie.ban_id!=null ? 'text-danger' : 'text-muted'" ng-show="modalmovie.is_quick_rate" ng-click="modalmovie.is_quick_rate ? quick_ban() : ban(modalmovie.index)">
									<i class="fa fa-ban" aria-hidden="true"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>