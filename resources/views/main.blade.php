@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_main')

@section('body')
<div class="d-none">
	Movies: now playing | most green | last green
	Series: airing today | most green | last green
	People: who born today | most popular
	Users: most liked | similar to your taste
	Reviews: most liked | last added | last liked
	Lists: most liked | last added | last liked
</div>
<div class="dropdown d-inline mr-2">
    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle px-3 px-md-0 border-0 background-inherit nowrap" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_1=0">
    <span class="h5" ng-show="page_variables.active_tab_1==0">now playing</span>
    <span class="h5" ng-if="page_variables.active_tab_1==1">most green</span>
    </button>
    <div class="dropdown-menu">
        <button class="dropdown-item" ng-click="page_variables.active_tab_1=0;set_recommendations();">now playing</button>
        <button class="dropdown-item" ng-click="page_variables.active_tab_1=1;set_recommendations();">most green</button>
    </div>
</div>
@endsection