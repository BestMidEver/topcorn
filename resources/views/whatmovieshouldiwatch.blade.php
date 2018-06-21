@extends(Auth::user() ? 'layout.applite' : 'layout.applitenew')

@include('head.head_whatmovieshouldiwatch')

@section('body')
<h1 class="text-center text-md-left col mt-3 mt-md-4">What Movie Should I Watch?</h1>
@endsection