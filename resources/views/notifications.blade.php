@extends('layout.app')

@include('head.head_notifications')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4">Notifications</h1>

<div class="mt-3">
    <div ng-repeat="notification in page_variables.notifications">
        <div class="d-flex py-2 pl-2 align-items-center background-lightgrey">
            <div class="flex-grow-1" ng-if="notification.data[0].notification_mode==0 || notification.data[0].notification_mode==1">
                <span class="text-success"><i class="fas fa-heart"></i></span>
                <span class="ml-2">@{{notification.total}} users liked your <a ng-href="@{{notification.data[0].review_mode==1?'movie':'series'}}/@{{notification.data[0].movie_id}}" class="text-dark">@{{notification.data[0].title}} @{{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}} review</a>. @{{notification.total>3?'Last 3':notification.total}} likes: <span ng-repeat="item in notification.data"><span ng-hide="$index==0">, </span>@{{item.user_name}}</span></span>
            </div>
            <div class="ml-2">
                <button class="btn addban"><i class="fa-circle" ng-class="notification.data[0].is_seen?'far':'fas'"></i></button>
            </div>
        </div>
        <hr class="m-0">
    </div>
    <div class="d-flex py-2 pl-2 align-items-center">
        <div class="flex-grow-1">
            <span class="text-success"><i class="fas fa-heart"></i></span>
            <span class="ml-2">15 users liked your <a href="" class="text-dark">"Best cartoon movies" list</a>. Last 3 likes: Nicoletta, Carlos sarboza and Movie Addicted</span>
        </div>
        <div class="ml-2">
            <button class="btn addban"><i class="far fa-circle"></i></button>
        </div>
    </div>
    <hr class="m-0">
    <div class="d-flex py-2 pl-2 align-items-center background-lightgrey">
        <div class="flex-grow-1">
            <span class="text-success"><i class="fas fa-wrench"></i></span>
            <span class="ml-2">New feature added. Notifications. You can change notification settings from settings.</span>
        </div>
        <div class="ml-2">
            <button class="btn addban"><i class="fas fa-circle"></i></button>
        </div>
    </div>
    <hr class="m-0">
    <div class="d-flex py-2 pl-2 align-items-center background-lightgrey">
        <div class="flex-grow-1">
            <span class="text-success"><i class="fas fa-film"></i></span>
            <span class="ml-2"><a href="" class="text-dark">Revenge (2017)</a> is recommended to you. Recommender user: Niki Szamos</span>
        </div>
        <div class="ml-2">
            <button class="btn addban"><i class="fas fa-circle"></i></button>
        </div>
    </div>
    <hr class="m-0">
    <div class="d-flex py-2 pl-2 align-items-center">
        <div class="flex-grow-1">
            <span class="text-success"><i class="fas fa-tv"></i></span>
            <span class="ml-2"><a href="" class="text-dark">Game of Thrones (2011)</a> air date is defined. Date: 2019-07-11 (55 days later)</span>
        </div>
        <div class="ml-2">
            <button class="btn addban"><i class="far fa-circle"></i></button>
        </div>
    </div>
    <hr class="m-0">
</div>

@endsection