@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_main')

@section('body')
Movies: now playing | most green | last green
Series: airing today | most green | last green
People: who born today | most popular
Users: most liked | similar to your taste
Reviews: most liked | last added | last liked
Lists: most liked | last added | last liked
@endsection