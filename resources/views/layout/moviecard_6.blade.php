<div class="card-group no-gutters">
	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="movie in similar_movies{{ $suffix }} | limitTo:6">
        @include('layout.moviecard_6_inside', ['suffix' => ''])
	</div>
</div>
<div class="collapse" id="collapseMovies">
	<div ng-if="similar_movies{{ $suffix }}.length > 6">
		<div class="card-group no-gutters">
        	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="movie in similar_movies{{ $suffix }} | limitTo:100:6">
                @include('layout.moviecard_6_inside', ['suffix' => '+6'])
        	</div>
        </div>
    </div>
</div>
<div class="text-center pt-1" ng-hide="iscast_movies || !(similar_movies{{ $suffix }}.length>6)">
    <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast_movies = true;" data-toggle="collapse" data-target="#collapseMovies"><small>{{__('general.show_all')}}</small></button>
</div>
<div class="text-center pt-1" ng-show="iscast_movies && similar_movies{{ $suffix }}.length>6">
    <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast_movies = false;" data-toggle="collapse" data-target="#collapseMovies"><i class="fa fa-angle-up"></i></button>
</div>