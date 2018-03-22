@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h4 text-center text-md-left col mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="text-muted col"><small>5 ay önce eklendi, en son 23 gün önce güncellendi.</small></div>

<div class="col mt-2">
	<a href="#">
		<img src="https://graph.facebook.com/v2.10/10211736611553891/picture?type=normal" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="list-thumbnail" alt="Responsive image">
		<span class="text-dark">Szofijjja</span>
	</a>
</div>

<div class="container-fluid mt-3">
	<span class="h6">1. Elveda Las Vegas (1995)</span>
	<img src="https://image.tmdb.org/t/p/w1280/2gJDuPxrZBns5ab47HQbyU2l6Im.jpg" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid coverpic" alt="Responsive image">
</div>
@endsection