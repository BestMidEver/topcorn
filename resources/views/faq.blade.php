@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_faq')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.faq_long') }}</h5>

<div class="h6 mt-5">
	What is this website about?
</div>
<div class="quote-line lead">
	Topcorn.io is a personalized movie recommendation engine. In other words, topcorn.io understands your unique taste and gives you movie suggestions based on it.
</div>


<p class="mt-5 text-muted">This product uses the TMDb API but is not endorsed or certified by TMDb.<a href="https://www.themoviedb.org/" target="_blank"><img class="tmdblogo ml-2" src="/images/tmdb.svg"></a></p>
@endsection