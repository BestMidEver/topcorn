@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h4 text-center text-md-left col mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="text-muted col"><small>5 ay önce eklendi, en son 23 gün önce güncellendi.</small></div>
<div class="text-muted col mt-2"><span class="h6">Listeyi Oluşturan:</span> <a href="#" class="text-dark">YellowWölf</a></div>
@endsection