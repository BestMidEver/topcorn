@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_main')

@section('body')
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==1" id="scroll_to_top1">
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="page_variables.active_tab_1=5">
				    <span class="h5" ng-show="page_variables.active_tab_1==5">Movies: Legendary</span>
				    <span class="h5" ng-show="page_variables.active_tab_1==4">Movies: Good</span>
				    <span class="h5" ng-show="page_variables.active_tab_1=='now playing'">Movies: Now Playing</span>
			    </button>
			    <div class="dropdown-menu">
					<button class="dropdown-item" ng-click="page_variables.active_tab_1=5;get_first_page_data(1);">Legendary</button>
					<button class="dropdown-item" ng-click="page_variables.active_tab_1=4;get_first_page_data(1);">Good</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_1='now playing';get_first_page_data(1);">Now Playing</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=1;iscast_movies1=true;is_expanded1=true;toggle_collapse('collapseMovies1', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;is_expanded1=false;iscast_movies1=false;toggle_collapse('collapseMovies1', 'collapse');scroll_to_top('scroll_to_top1');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div class="container-fluid" ng-show="iscast_movies1">
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_following1=='following'">Following</span>
				<span ng-show="page_variables.f_following1=='all'">All Users</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_following1='following';get_first_page_data(1);">Following</button>
				<button class="dropdown-item" ng-click="page_variables.f_following1='all';get_first_page_data(1);">All Users</button>
			</div>
		</div>
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mr-2 mt-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-sort-amount-down"></i>
				<span ng-show="page_variables.f_sort1=='newest'">Newest</span>
				<span ng-show="page_variables.f_sort1=='most voted'">Most Voted</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_sort1='newest';get_first_page_data(1);">Newest</button>
				<button class="dropdown-item" ng-click="page_variables.f_sort1='most voted';get_first_page_data(1);">Most Voted</button>
			</div>
		</div>
	</div>
	<div ng-show="similar_movies1.length>0">
    @include('layout.moviecard_6', ['suffix' => '1'])
	</div>
</div>
<hr class="mt-4" ng-show="page_variables.expanded==-1">
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==2" id="scroll_to_top2">
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
			<div class="dropdown d-inline">
			    <button class="btn btn-lg btn-outline-dark text-dark dropdown-toggle border-0 background-inherit nowrap mr-2 py-0 px-md-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <span class="h5" ng-show="page_variables.active_tab_2==5">Series: Legendary</span>
			    <span class="h5" ng-show="page_variables.active_tab_2==4">Series: Good</span>
			    <span class="h5" ng-show="page_variables.active_tab_2=='on air'">Series: On The Air</span>
			    </button>
			    <div class="dropdown-menu">
			        <button class="dropdown-item" ng-click="page_variables.active_tab_2=5;get_first_page_data(2);">Legendary</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_2=4;get_first_page_data(2);">Good</button>
			        <button class="dropdown-item" ng-click="page_variables.active_tab_2='on air';get_first_page_data(2);">On The Air</button>
			    </div>
			</div>
		</div>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=2;iscast_movies2=true;is_expanded2=true;toggle_collapse('collapseMovies2', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;is_expanded2=false;iscast_movies2=false;toggle_collapse('collapseMovies2', 'collapse');scroll_to_top('scroll_to_top2');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div class="container-fluid" ng-show="similar_movies2">
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mt-3 mr-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-filter"></i>
				<span ng-show="page_variables.f_following2=='following'">Following</span>
				<span ng-show="page_variables.f_following2=='all'">All Users</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_following2='following';get_first_page_data(2);">Following</button>
				<button class="dropdown-item" ng-click="page_variables.f_following2='all';get_first_page_data(2);">All Users</button>
			</div>
		</div>
		<div class="dropdown d-inline">
			<button class="btn btn-outline-secondary dropdown-toggle mr-2 mt-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-sort-amount-down"></i>
				<span ng-show="page_variables.f_sort2=='newest'">Newest</span>
				<span ng-show="page_variables.f_sort2=='most voted'">Most Voted</span>
			</button>
			<div class="dropdown-menu">
				<button class="dropdown-item" ng-click="page_variables.f_sort2='newest';get_first_page_data(2);">Newest</button>
				<button class="dropdown-item" ng-click="page_variables.f_sort2='most voted';get_first_page_data(2);">Most Voted</button>
			</div>
		</div>
	</div>
	<div ng-show="similar_movies2.length>0">
    @include('layout.moviecard_6', ['suffix' => '2'])
	</div>
</div>
<hr class="mt-4" ng-show="page_variables.expanded==-1">
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==3" id="scroll_to_top3">
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
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
		</div>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=3;iscast3=true;is_expanded3=true;toggle_collapse('collapseCast3', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast3=false;is_expanded3=false;toggle_collapse('collapseCast3', 'collapse');scroll_to_top('scroll_to_top3');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div ng-show="people3.length>0">
    @include('layout.peoplecard_6', ['suffix' => '3'])
	</div>
</div>
<hr class="mt-4" ng-show="page_variables.expanded==-1">
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==4" id="scroll_to_top4">
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
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
		</div>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=4;iscast4=true;is_expanded4=true;toggle_collapse('collapseMovies4', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast4=false;is_expanded4=false;toggle_collapse('collapseMovies4', 'collapse');scroll_to_top('scroll_to_top4');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div ng-show="users4.length>0">
    @include('layout.userscard_6', ['suffix' => '4'])
	</div>
</div>
<hr class="mt-4" ng-show="page_variables.expanded==-1">
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==5" id="scroll_to_top5">
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
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
		</div>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=5;iscast5=true;is_expanded5=true;toggle_collapse('collapseMovies5', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast5=false;is_expanded5=false;toggle_collapse('collapseMovies5', 'collapse');scroll_to_top('scroll_to_top5');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div ng-show="reviews5.length>0">
    @include('layout.reviews_6', ['suffix' => '5'])
	</div>
</div>
<hr class="mt-4" ng-show="page_variables.expanded==-1">
<div class="mt-4" ng-show="page_variables.expanded==-1 || page_variables.expanded==6" id="scroll_to_top6">
	<div class="h5 px-3 px-md-0 mb-0 d-flex justify-content-between">
		<div>
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
		</div>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.expand') }}" ng-click="page_variables.expanded=6;iscast6=true;is_expanded6=true;toggle_collapse('collapseMovies6', 'expand');" ng-show="page_variables.expanded==-1"><div><i class="fas fa-arrows-alt"></i></div></button>
		<button class="btn btn-outline-secondary addblack border-0" data-toggle="tooltip" data-placement="top" title="{{ __('general.compress') }}" ng-click="page_variables.expanded=-1;iscast6=false;is_expanded6=false;toggle_collapse('collapseMovies6', 'collapse');scroll_to_top('scroll_to_top6');" ng-show="page_variables.expanded!=-1"><div><i class="fas fa-compress-arrows-alt"></i></div></button>
	</div>
	<div ng-show="listes6.length>0">
		@include('layout.listcard_6', ['suffix' => '6'])
	</div>
</div>
@endsection