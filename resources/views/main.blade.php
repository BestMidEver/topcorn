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
<div class="dropdown d-inline pl-3">
    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 mt-3 mt-md-4 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_1=0">
    <span class="h5" ng-show="page_variables.active_tab_1==0">Movies: Newest</span>
    <span class="h5" ng-if="page_variables.active_tab_1==1">Movies: Legendary</span>
    <span class="h5" ng-if="page_variables.active_tab_1==1">Movies: Garbage</span>
    </button>
    <div class="dropdown-menu">
        <button class="dropdown-item" ng-click="page_variables.active_tab_1=0;">Newest</button>
        <button class="dropdown-item" ng-click="page_variables.active_tab_1=1;">Legendary</button>
        <button class="dropdown-item" ng-click="page_variables.active_tab_1=2;">Garbage</button>
    </div>
</div>
@endsection