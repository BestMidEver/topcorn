<div class="container-fluid">
	<div class="py-4" ng-repeat="review in reviews{{ $suffix }} | limitTo:3">
        <div class="d-flex justify-content-between">
            <div class="h6 pb-2" ng-if="review.author.length>0">@{{review.author}}</div>
            <div class="d-inline" ng-if="review.name.length>0"><a class="h6 pb-2 text-dark d-inline" ng-href="/@{{review.mode==1?'movie':'series'}}/@{{review.movie_series_id}}" data-toggle="tooltip" data-placement="top" title="@{{review.original_title}}">@{{review.movie_title}} <small class="text-muted" ng-if="review.release_date.length > 0"><em>(@{{review.release_date.substring(0, 4)}})</em></small></a> <em>|</em> <a class="h6 pb-2 text-dark d-inline" ng-href="/profile/@{{review.user_id}}">@{{review.name}}</a> <span class="ml-2" ng-if="review.rate>0"><i class="fas fa-star" ng-class="{1:'text-danger', 2:'text-warning', 3:'text-secondary', 4:'text-info', 5:'text-success'}[review.rate]" ng-repeat="n in [] | range:review.rate"></i><i class="far fa-star text-muted" ng-repeat="n in [] | range:(5-review.rate)"></i></span></div>
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
<div class="collapse container-fluid" id="collapseMovies{{ $suffix }}">
	<div ng-if="reviews{{ $suffix }}.length > 3">
    	<div class="py-4" ng-repeat="review in reviews{{ $suffix }} | limitTo:100:3">
            <div class="d-flex justify-content-between">
                <div class="h6 pb-2" ng-if="review.author.length>0">@{{review.author}}</div>
                <div class="d-inline" ng-if="review.name.length>0"><a class="h6 pb-2 text-dark d-inline" ng-href="/@{{review.mode==1?'movie':'series'}}/@{{review.movie_series_id}}" data-toggle="tooltip" data-placement="top" title="@{{review.original_title}}">@{{review.movie_title}} <small class="text-muted" ng-if="review.release_date.length > 0"><em>(@{{review.release_date.substring(0, 4)}})</em></small></a> <em>|</em> <a class="h6 pb-2 text-dark d-inline" ng-href="/profile/@{{review.user_id}}">@{{review.name}}</a> <span class="ml-2" ng-if="review.rate>0"><i class="fas fa-star" ng-class="{1:'text-danger', 2:'text-warning', 3:'text-secondary', 4:'text-info', 5:'text-success'}[review.rate]" ng-repeat="n in [] | range:review.rate"></i><i class="far fa-star text-muted" ng-repeat="n in [] | range:(5-review.rate)"></i></span></div>
                <div class="h6">
                    <button class="btn btn-outline-secondary btn-sm border-0 mt-0 addseen opacity-1" ng-disabled="review.is_mine==1||review.is_mine==undefined" ng-click="like_review($index)">
                        <div ng-class="{'text-success':review.count>0}"><i class="fa-heart" ng-class="{0:'far', 1:'fas', undefined:'far'}[review.is_liked]"></i><span ng-if="review.count>0"> @{{review.count}}</span></div>
                    </button>
                </div>
            </div>
            <div id="@{{'accordion'+($index+3)}}">
                <div ng-if="review.id == 'long'">
                    <div id="@{{'collapse'+($index+3)+'a'}}" data-parent="@{{'#accordion'+($index+3)}}" class="lead lead-small collapse">
                        <div>
                            <div ng-bind-html="review.content"></div>
                        </div>
                        <div class="text-center pt-0">
                            <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white hidereview" data-toggle="collapse" data-target="@{{'#collapse'+($index+6)+'b'}}" aria-expanded="true"><i class="fa fa-angle-up"></i></button>
                        </div>
                    </div>
                </div>
                <div>
                    <div id="@{{'collapse'+($index+3)+'b'}}" data-parent="@{{'#accordion'+($index+3)}}" class="lead lead-small collapse show">
                        <div>
                            <div ng-bind-html="review.url"></div>
                        </div>
                        <div ng-if="review.id == 'long'">
                            <div class="text-center pt-1">
                                <button class="btn btn-outline-secondary border-0 text-muted hover-white showreview" data-toggle="collapse" data-target="@{{'#collapse'+($index+3)+'a'}}" aria-expanded="false"><small>{{ __('general.read_all') }}</small></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div ng-show="iscast_movies{{  $suffix  }}">
@include('layout.pagination', ['suffix' => '_'.$suffix])
</div>
<div class="text-center pt-1" ng-hide="iscast_movies{{ $suffix }} || !(reviews{{ $suffix }}.length>3)">
    <button class="btn btn-outline-secondary border-0 text-muted hover-white" ng-click="iscast_movies{{ $suffix }} = true;" data-toggle="collapse" data-target="#collapseMovies{{ $suffix }}"><small>{{__('general.show_all')}}</small></button>
</div>
<div class="text-center pt-1" ng-show="iscast_movies{{ $suffix }} && reviews{{ $suffix }}.length>3">
    <button class="btn btn-outline-secondary btn-lg fa40 border-0 text-muted hover-white" ng-click="iscast_movies{{ $suffix }} = false;" data-toggle="collapse" data-target="#collapseMovies{{ $suffix }}"><i class="fa fa-angle-up"></i></button>
</div>