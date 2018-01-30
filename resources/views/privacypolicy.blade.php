@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_privacypolicy')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.privacy') }}</h5>
@endsection