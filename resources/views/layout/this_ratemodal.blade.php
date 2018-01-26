<div class="modal fade" id="this_movie_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="votecard modal-dialog mt-0" role="document">
		<div class="modal-content">
			<div class="card">
				<img class="card-img" ng-src="{{config('constants.image.rate_modal')[$image_quality]}}@{{movie.poster_path}}" on-error-src="{{config('constants.image.rate_modal_error')}}" alt="Card image">
				<div class="card-img-overlay p-2">
					<div class="text-center h-100 d-flex flex-column justify-content-between">
						<div class="d-flex flex-row justify-content-between">
							<div class="faderdiv">
								<button type="button" class="btn btn-secondary btn-sm badge-light float-left" data-toggle="tooltip" data-placement="bottom" title="Bu filmi izlemediğini farzet, sana önereyim mi?">
									<i class="fa fa-question" aria-hidden="true"></i>
								</button>
							</div>
							<div class="faderdiv">
								<h4><a href="/movie/@{{movie.id}}" target={{$target}} data-toggle="tooltip" data-placement="bottom" title="@{{movie.original_title}}"><span class="badge badge-light yeswrap p-1">@{{movie.title}} <small><em>(@{{movie.release_date.substring(0, 4)}})</em></small></span></a></h4>
							</div>
							<div class="faderdiv">
								<button type="button" class="btn btn-secondary btn-sm badge-light float-right" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
								</button>
							</div>
						</div>
						<div class="d-flex flex-column votediv">
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-success btn-lg" ng-class="{'bordered_button':user_movie_record.rate_code==5}" ng-click="this_rate(5)">{{ __('general.definitely_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-info btn-lg" ng-class="{'bordered_button':user_movie_record.rate_code==4}" ng-click="this_rate(4)">{{ __('general.recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-secondary btn-lg" ng-class="{'bordered_button':user_movie_record.rate_code==3}" ng-click="this_rate(3)">{{ __('general.not_sure') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-warning btn-lg" ng-class="{'bordered_button':user_movie_record.rate_code==2}" ng-click="this_rate(2)">{{ __('general.dont_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
							<div class="d-flex flex-row justify-content-between mt-2">
								<div class=""></div>
								<div class="faderdiv">
									<button class="btn btn-danger btn-lg" ng-class="{'bordered_button':user_movie_record.rate_code==1}" ng-click="this_rate(1)">{{ __('general.definitely_dont_recommend') }}</button>
								</div>
								<div class=""></div>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-between align-items-end">
							<div class="faderdiv">
								<button type="button" class="btn btn-secondary btn-sm badge-light float-left" ng-show="modalmovie.is_quick_rate">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
								</button>
							</div>
							<div class="faderdiv">
								<button class="btn btn-secondary badge-light btn-lg p-1" ng-click="this_rate(null)">{{ __('general.havent_seen') }}</button>
							</div>
							<div class="faderdiv">
								<button type="button" class="btn btn-secondary btn-sm badge-light float-left" ng-show="modalmovie.is_quick_rate">
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