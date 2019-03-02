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
<div>
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 mt-3 mt-md-4 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_1=0">
	    <span class="h5" ng-show="page_variables.active_tab_1==0">Movies: Now Playing</span>
	    <span class="h5" ng-if="page_variables.active_tab_1==1">Movies: Legendary</span>
	    <span class="h5" ng-if="page_variables.active_tab_1==2">Movies: Garbage</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_1=0;">Now Playing</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_1=1;">Legendary</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_1=2;">Garbage</button>
	    </div>
	</div>
	<div ng-show="similar_movies1.length>0">
    @include('layout.moviecard_6', ['suffix' => '1'])
	</div>
</div>
<div class="mt-5">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_2=0">
	    <span class="h5" ng-show="page_variables.active_tab_2==0">Series: On The Air</span>
	    <span class="h5" ng-if="page_variables.active_tab_2==1">Series: Legendary</span>
	    <span class="h5" ng-if="page_variables.active_tab_2==1">Series: Garbage</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_2=0;">On The Air</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_2=1;">Legendary</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_2=2;">Garbage</button>
	    </div>
	</div>
	<div ng-show="similar_movies2.length>0">
    @include('layout.moviecard_6', ['suffix' => '2'])
	</div>
</div>
<div class="mt-5">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_3=1">
	    <span class="h5" ng-show="page_variables.active_tab_3==0">People: Who Born Today</span>
	    <span class="h5" ng-if="page_variables.active_tab_3==1">People: Most Popular</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_3=0;">Who Born Today</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_3=1;">Most Popular</button>
	    </div>
	</div>
	<div ng-show="similar_movies2.length>0">
    @include('layout.peoplecard_6', ['suffix' => '3'])
	</div>
</div>
<div class="mt-5">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_4=0">
	    <span class="h5" ng-show="page_variables.active_tab_4==0">Users: Most Liked Commenters</span>
	    <span class="h5" ng-if="page_variables.active_tab_4==1">Users: Most Liked List Creators</span>
	    <span class="h5" ng-if="page_variables.active_tab_4==2">Users: Most Followed</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4=0;">Most Liked Commenters</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4=1;">Most Liked List Creators</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4=2;">Most Followed</button>
	    </div>
	</div>
	<div ng-show="users4.length>0">
    @include('layout.usersscard_6', ['suffix' => '4'])
	</div>
</div>









<div class="mt-5">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_4=0">
	    <span class="h5" ng-show="page_variables.active_tab_4==0">Reviews: Most Liked</span>
	    <span class="h5" ng-if="page_variables.active_tab_4==1">Reviews: Newest</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4=0;">Most Liked</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4=1;">Newest</button>
	    </div>
	</div>
</div>
<div class="mt-5">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_5=0">
	    <span class="h5" ng-show="page_variables.active_tab_5==0">Lists: Most Liked</span>
	    <span class="h5" ng-if="page_variables.active_tab_5==1">Lists: Newest</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_5=0;">Most Liked</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_5=1;">Newest</button>
	    </div>
	</div>
</div>
@endsection