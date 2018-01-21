@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_profile')

@section('body')
<div class="position-relative mt-md-4">
	<img ng-src="{{config('constants.image.cover')[$image_quality]}}{{ $profile_cover_pic }}" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
	<div class="coveroverlayersmall d-md-none">
		<div class="d-flex flex-column align-items-center">
			<div class="d-flex flex-column">
				<div class="d-flex flex-row align-items-center">
					<img ng-src="{{ $profile_profile_pic }}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicsmall" alt="Responsive image">
					<h5><span class="badge badge-light ml-2 yeswrap text-left">{{ $profile_user_name }}</span></h5>
				</div>
				@if(Auth::check())
				<div class="d-flex flex-row">
					@if($profile_user_id == Auth::user()->id)
					<a class="btn btn-warning mt-1 btn-block text-white" href="/account"><i class="fa fa-cog" aria-hidden="true"></i> {{ __('navbar.account') }}</a>
					@else				
					<a class="btn btn-warning mt-1 btn-block text-white" href="/recommendations/{{$profile_user_id}}"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('general.watch_together') }}</a>
					@endif
				</div>
				@endif
			</div>
		</div>
	</div>
	<div class="coveroverlayermedium d-none d-md-inline">
		<div class="d-flex flex-column">
			<div class="d-flex flex-row align-items-center">
				<img ng-src="{{ $profile_profile_pic }}" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="img-thumbnail profilepicmedium" alt="Responsive image">
				<h5><span class="badge badge-light ml-2 yeswrap text-left">{{ $profile_user_name }}</span></h5>
			</div>
			@if(Auth::check())
			<div class="d-flex flex-row">
				@if($profile_user_id == Auth::user()->id)
				<a class="btn btn-warning mt-2 btn-block text-white" href="/account"><i class="fa fa-cog" aria-hidden="true"></i> {{ __('navbar.account') }}</a>
				@else
				<a class="btn btn-warning mt-2 btn-block text-white" href="/recommendations/{{$profile_user_id}}"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('general.watch_together') }}</a>
				@endif
			</div>
			@endif
		</div>
	</div>
</div>

<div class="container-fluid mt-3 pb-3">
	<ul class="nav justify-content-md-center tab1">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab!='get_laters' && active_tab!='get_bans'}" ng-click="active_tab='get_rateds/5';get_first_page_data()">{{ __('general.seen_movies') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_laters'}" ng-click="active_tab='get_laters';get_first_page_data();">{{ __('general.watch_later') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='get_bans'}" ng-click="active_tab='get_bans';get_first_page_data();">{{ __('general.banneds') }}</button>
		</li>
	</ul>
</div>

<div class="container-fluid" ng-show="active_tab!='get_laters' && active_tab!='get_bans'">
	<div class="dropdown" ng-init="mod_title='Kesinlikle Öner'">
		<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			@{{mod_title}}
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<button class="dropdown-item" ng-click="mod_title='Kesinlikle Öner';active_tab='get_rateds/5';get_first_page_data();">{{ __('general.definitely_recommend') }}</button>
			<button class="dropdown-item" ng-click="mod_title='Öner';active_tab='get_rateds/4';get_first_page_data();">{{ __('general.recommend') }}</button>
			<button class="dropdown-item" ng-click="mod_title='Kararsız';active_tab='get_rateds/3';get_first_page_data();">{{ __('general.not_sure') }}</button>
			<button class="dropdown-item" ng-click="mod_title='Önerme';active_tab='get_rateds/2';get_first_page_data();">{{ __('general.dont_recommend') }}</button>
			<button class="dropdown-item" ng-click="mod_title='Kesinlikle Önerme';active_tab='get_rateds/1';get_first_page_data();">{{ __('general.definitely_dont_recommend') }}</button>
			<div class="dropdown-divider"></div>
			<button class="dropdown-item" ng-click="mod_title='Hepsi';active_tab='get_rateds/all';get_first_page_data();">{{ __('general.all') }}</button>
		</div>
	</div>
</div>

<div id="scroll_top_point">
<div class="p-5" ng-show="movies.length==0">
	<div class="text-muted text-center">{{ __('general.no_result') }}</div>
</div>
@include('layout.moviecard')
</div>

@include('layout.pagination', ['suffix' => ''])

@endsection
