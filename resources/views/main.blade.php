@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_main')

@section('body')
<div class=" mt-3 mt-md-4">
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_1='legendary'">
			    <span class="h5" ng-show="page_variables.active_tab_1=='legendary'">Movies: Legendary</span>
			    <span class="h5" ng-show="page_variables.active_tab_1=='garbage'">Movies: Garbage</span>
			    <span class="h5" ng-show="page_variables.active_tab_1=='now playing'">Movies: Now Playing</span>
			    </button>
			    <div class="dropdown-menu">
			        <button class="dropdown-item" ng-click="page_variables.active_tab_1='legendary';get_first_page_data(1);">Legendary</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_1='garbage';get_first_page_data(1);">Garbage</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_1='now playing';get_first_page_data(1);">Now Playing</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=1" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div ng-show="similar_movies1.length>0">
    @include('layout.moviecard_6', ['suffix' => '1'])
	</div>
</div>
<hr class="mt-4">
<div class="mt-4">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_2='legendary'">
	    <span class="h5" ng-show="page_variables.active_tab_2=='legendary'">Series: Legendary</span>
	    <span class="h5" ng-show="page_variables.active_tab_2=='garbage'">Series: Garbage</span>
	    <span class="h5" ng-show="page_variables.active_tab_2=='on air'">Series: On The Air</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_2='legendary';get_first_page_data(2);">Legendary</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_2='garbage';get_first_page_data(2);">Garbage</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_2='on air';get_first_page_data(2);">On The Air</button>
	    </div>
	</div>
	<div ng-show="similar_movies2.length>0">
    @include('layout.moviecard_6', ['suffix' => '2'])
	</div>
</div>
<hr class="mt-4">
<div class="mt-4">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_3='born today'">
		    <span class="h5" ng-show="page_variables.active_tab_3=='born today'">People: Born Today</span>
		    <span class="h5" ng-show="page_variables.active_tab_3=='died today'">People: Died Today</span>
		    <span class="h5" ng-show="page_variables.active_tab_3=='most popular'">People: Most Popular</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_3='born today';get_first_page_data(3);">Born Today</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_3='died today';get_first_page_data(3);">Died Today</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_3='most popular';get_first_page_data(3);">Most Popular</button>
	    </div>
	</div>
	<div ng-show="people3.length>0">
    @include('layout.peoplecard_6', ['suffix' => '3'])
	</div>
</div>
<hr class="mt-4">
<div class="mt-4">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_4='comment'">
		    <span class="h5" ng-show="page_variables.active_tab_4=='comment'">Users: Most Liked Commenters</span>
		    <span class="h5" ng-show="page_variables.active_tab_4=='list'">Users: Most Liked List Creators</span>
		    <span class="h5" ng-show="page_variables.active_tab_4=='follow'">Users: Most Followed</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4='comment';get_first_page_data(4);">Most Liked Commenters</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4='list';get_first_page_data(4);">Most Liked List Creators</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_4='follow';get_first_page_data(4);">Most Followed</button>
	    </div>
	</div>
	<div ng-show="users4.length>0">
    @include('layout.userscard_6', ['suffix' => '4'])
	</div>
</div>
<hr class="mt-4">
<div class="mt-4">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_5='newest'">
	    <span class="h5" ng-show="page_variables.active_tab_5=='newest'">Reviews: Newest</span>
	    <span class="h5" ng-show="page_variables.active_tab_5=='most liked'">Reviews: Most Liked</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_5='newest';get_first_page_data(5);">Newest</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_5='most liked';get_first_page_data(5);">Most Liked</button>
	    </div>
	</div>
	<div ng-show="reviews5.length>0">
    @include('layout.reviews_6', ['suffix' => '5'])
	</div>
</div>
<hr class="mt-4">
<div class="mt-4">
	<div class="dropdown d-inline">
	    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_6='newest'">
	    <span class="h5" ng-show="page_variables.active_tab_6=='newest'">Lists: Newest</span>
	    <span class="h5" ng-show="page_variables.active_tab_6=='most liked'">Lists: Most Liked</span>
	    </button>
	    <div class="dropdown-menu">
	        <button class="dropdown-item" ng-click="page_variables.active_tab_6='newest';;get_first_page_data(6);">Newest</button>
	        <button class="dropdown-item" ng-click="page_variables.active_tab_6='most liked';;get_first_page_data(6);">Most Liked</button>
	    </div>
	</div>
	<div ng-show="listes6.length>0">
		@include('layout.listcard_6', ['suffix' => '6'])
	</div>
</div>
@endsection