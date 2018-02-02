@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_faq')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.faq_long') }}</h5>

<p>This product uses the TMDb API but is not endorsed or certified by TMDb.<a href="https://www.themoviedb.org/" target="_blank"><img class="tmdblogo ml-2" src="/images/tmdb.svg"></a></p>
@endsection