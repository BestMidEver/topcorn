@extends('layout.app')

@include('head.head_account')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4">Notifications</h1>
{{$notifications}}
<div class="mt-3">
    <div class="d-flex py-2 pl-2 align-items-center background-lightgrey">
        <div class="flex-grow-1">
            <span class="text-success"><i class="fas fa-heart"></i></span>
            <span class="ml-2">15 users liked your <a href="" class="text-dark">Memento (2000) review</a>. Last 3 likes: Uygar, Joğfi and mekk mesterr</span>
        </div>
        <div class="ml-2">
            <button class="btn addban"><i class="fas fa-circle"></i></button>
        </div>
    </div>
    <hr class="m-0">
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