@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="text-muted"><small>5 ay önce eklendi, en son 23 gün önce güncellendi.</small></div>
@endsection