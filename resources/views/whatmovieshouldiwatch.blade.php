@extends(Auth::user() ? 'layout.applite' : 'layout.applitenew')

@include('head.head_whatmovieshouldiwatch')

@section('body')
<div class="col-12 col-lg-8">
	<h1 class="text-center text-md-left col mt-3 mt-md-4">What Movie Should I Watch</h1>

	<div class="p-3">
		<p>Humankind started to make films at the end of the 19th centuary. Since then the film industry grew rapidly. Nowadays we have access to hundreds of thousands of movies. Because we are mortals and we don’t have infinite time, we can’t possibly watch all of them. That makes you ask the question <strong>What movie should I watch?</strong>
		</p>
	</div>
</div>
@endsection