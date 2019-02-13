@extends('layout.app')

@include('head.head_notifications')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4">Notifications</h1>

<div class="mt-3">
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
                <span class="ml-2">@{{notification.data[0].user_name}} watched together with you. You can send movies/series to him/her.</span>
            </div>
            <div class="ml-2">
                <button class="btn btn-outline-secondary border-0 addban" ng-click="set_seen(notification.data[0])"><i class="fa-circle" ng-class="notification.data[0].is_seen?'far':'fas'"></i></button>
            </div>
        </div>
        <hr class="m-0">
    </div>
</div>

@endsection