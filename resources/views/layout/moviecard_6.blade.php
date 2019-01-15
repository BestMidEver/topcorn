<div class="card-group no-gutters">
	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="movie in movies | limitTo:6">
		@include('layout.moviecard_6_inside')
	</div>
</div>
<div class="card-group no-gutters">
    <div class="collapse" id="collapseMovies">
        <div ng-if="movies.length > 6">
        	<div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-4" ng-repeat="movie in movies | limitTo:100:6">
        		@include('layout.moviecard_6_inside')
        	</div>
        </div>
    </div>
</div>
<div class="text-center pt-1" ng-hide="iscast_movies">
    <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast_movies = true;" data-toggle="collapse" data-target="#collapseMovies"><small>Show All</small></button>
</div>
<div class="text-center pt-1" ng-show="iscast_movies">
    <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast_movies = false;" data-toggle="collapse" data-target="#collapseMovies"><i class="fa fa-angle-up"></i></button>
</div>