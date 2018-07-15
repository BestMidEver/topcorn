<div class="card-group no-gutters">
	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="person in people">
		<div class="card mx-sm-2">
			<a href="/person/@{{person.id}}" target={{$target}}>
				<img class="card-img-top" ng-src="{{config('constants.image.movie_card')[$image_quality]}}@{{person.profile_path}}" on-error-src="{{config('constants.image.movie_card_error')}}" alt="Card image cap">
				<div class="card-block">
					<h6 class="card-title p-1 mb-1 text-dark text-center">@{{person.name}}</h6>
				</div>
			</a>
		</div>
	</div>
</div>