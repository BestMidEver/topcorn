@extends('layout.app')

@include('head.head_notifications')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.notifications') }}</h1>




<!-- Page Body -->
<div ng-hide="is_waiting">
    <div class="mt-3" id="scroll_top_point">
        <div ng-repeat="notification in page_variables.notifications">
            <div class="d-flex py-2 pl-2 align-items-center" ng-class="notification.data[0].is_seen?'':'background-lightgrey'">
                <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==0 || notification.data[0].notification_mode==1">
                    <span class="text-success"><i class="fas fa-heart"></i></span>
                    <span class="ml-2">{!! __('long_texts.notifications.like') !!}</span>
                </div>
                <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==2">
                    <span class="text-secondary"><i class="@{{notification.data[0].icon}}"></i></span>
                    <span class="ml-2">@{{notification.data[0].notification}}</span>
                </div>
                <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==3">
                    <span class="text-warning"><i class="fas fa-clock"></i></span>
                    <span class="ml-2">{!! __('long_texts.notifications.air_date') !!}</span>
                </div>
                <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==4 || notification.data[0].notification_mode==5">
                    <span class="text-primary"><i class="fas fa-share"></i></span>
                    <span class="ml-2">{!! __('long_texts.notifications.sent_movie') !!}</span>
                </div>
                <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==6">
                    <span class="text-primary"><i class="fas fa-user-friends"></i></span>
                    <span class="ml-2">{!! __('long_texts.notifications.watch_together') !!}</span>
                </div>
                <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==7">
                    <span class="text-primary"><i class="fas fa-clock"></i></span>
                    <span class="ml-2">{!! __('long_texts.notifications.airing_today') !!}</span>
                </div>
                <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==8">
                    <span class="text-success"><i class="fas fa-user-friends"></i></span>
                    <span class="ml-2">{!! __('long_texts.notifications.started_following') !!}</span>
                </div>
                <div class="ml-2">
                    <button class="btn btn-outline-secondary border-0 addban" ng-click="set_seen(notification.data[0])"><i class="fa-circle" ng-class="notification.data[0].is_seen?'far':'fas'"></i></button>
                </div>
            </div>
            <hr class="m-0">
        </div>
        <div class="p-5" ng-show="is_waiting || page_variables.notifications.length==0">
            <div class="text-muted text-center" ng-if="!is_waiting">{{ __('general.no_notification') }}</div><div class="text-muted text-center" ng-if="is_waiting">{{ __('general.loading') }}</div>
        </div>
    </div>

    @include('layout.pagination', ['suffix' => ''])
</div>
<!-- Page Body -->




@if(Auth::id()==7)
<!-- Tabs Button -->
<div class="container-fluid mt-3 d-none d-md-inline">
    <ul class="nav justify-content-md-center tab1">
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted" ng-class="{'active':page_variables.active_tab=='new'}" ng-click="page_variables.active_tab='new';get_first_page_data();">{{ __('general.un_read') }}</button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link text-muted" ng-class="{'active':page_variables.active_tab=='old'}" ng-click="page_variables.active_tab='old';get_first_page_data();">{{ __('general.read') }}</button>
        </li>
    </ul>
</div>
<!-- Tabs Button -->




<!-- Tabs Button Mobile -->
<div class="scrollmenu my-3 tab2 d-md-none">
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':page_variables.active_tab=='new'}" ng-click="page_variables.active_tab='new';get_first_page_data();">{{ __('general.un_read') }}</button>
    <button class="btn btn-link border-no-radius text-sm-center text-muted text-no-decoration" ng-class="{'active':page_variables.active_tab=='old'}" ng-click="page_variables.active_tab='old';get_first_page_data();">{{ __('general.read') }}</button>
</div>
<!-- Tabs Button Mobile -->
@endif

@endsection